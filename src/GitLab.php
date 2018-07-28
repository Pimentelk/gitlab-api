<?php

	namespace Library;

	use GuzzleHttp\Client as GuzzleClient;

	class GitLab
	{
		/** @var string */
    	private $token;

    	/** @var string */
    	protected $baseURI;

    	/** @var string */
    	protected $basePath;

    	/** @var GuzzleHttp\Client as GuzzleClient */
    	protected $client;

		public function __construct(string $token, string $project_id, string $base_uri = null)
		{
			$this->token = $token;
			$this->basePath = "projects/{$project_id}";
			$this->baseURI = $base_uri ?? "https://gitlab.com/api/v4/";

			$this->client = new GuzzleClient([
				'base_uri' => $this->baseURI
			]);
		}

		public function setToken(string $token)
		{
			$this->token = $token;
		}

		public function setProjectId(string $id)
		{
			$this->basePath = "projects/{$id}";
		}

		public function call(string $method, string $path, array $params = [])
		{
			try {
				return json_decode(
					$this->client->request(
						$method,
						$path,
						array_merge(
							$this->getHeaders(),
							['form_params' => $params]
						)
					)->getBody()
				);
			} catch(Exception $e) {
				return $e->getMessage();
			}
		}

		public function merge(string $source_branch, string $target_branch, string $title, array $params = [])
		{
			return $this->call("POST", "{$this->basePath}/merge_requests", [
				"source_branch" => $source_branch,
				"target_branch" => $target_branch,
				"title" => $title,
			]);
		}

		public function getProjects()
		{
			return $this->call('GET', 'projects', [
				'membership' => true,
				'simple' => true
			]);
		}

		public function getMergeChanges(string $iid)
		{
			return $this->call("GET", "{$this->basePath}/merge_requests/{$iid}/changes");
		}

		public function acceptMergeRequest(string $iid, array $params = [])
		{
			return $this->call("PUT", "{$this->basePath}/merge_requests/{$iid}/merge");
		}

		public function deleteMergeRequest(string $iid)
		{
			return $this->call("DELETE", "{$this->basePath}/merge_requests/{$iid}");
		}

		public function deleteAllMergedFeatures()
		{
			return $this->call("DELETE", "{$this->basePath}/repository/merged_branches");
		}

		public function getUniqueBranchFeatures(string $base, string $compare) : array
		{
			$diff = array_diff(
				$this->getAllBranchMergedFeatures($base),
				$this->getAllBranchMergedFeatures($compare)
			);

			sort($diff, SORT_REGULAR);

			return $diff;
		}

		public function getAllRepositoryMergeRequests(string $state = 'all', string $order_by = 'created_at')
		{
			return $this->call('GET', "{$this->basePath}/merge_requests");
		}

		public function getAllBranchMergedFeatures(string $branch) : array
		{
			$merge_requests = $this->call("GET",
				"{$this->basePath}/merge_requests?state=merged&target_branch={$branch}"
			);

			return array_column($merge_requests, 'source_branch');
		}

		public function getAllMergedFeatures() : array
		{
			$merge_requests = $this->call("GET",
				"{$this->basePath}/merge_requests?state=merged"
			);

			return array_column($merge_requests, 'source_branch');
		}

		protected function getHeaders()
		{
			return [
				'headers' => [
					'Private-Token' => $this->token
				]
			];
		}
	}
