<?php

	require 'vendor/autoload.php';

	use Library\GitLab;

	$gitlab = new GitLab;

	var_dump($gitlab->getAllMergedFeatures());
	exit;
	// echo $gitlab->merge('kevin', 'master', 'Sick Merge Bro')->getBody();
	$projects = $gitlab->getProjects();
	$merges = $gitlab->getAllRepositoryMergeRequests();
 	$merge_changes = $gitlab->getMergeChanges('6');
	// $gitlab->acceptMergeRequest('6');
	// $gitlab->deleteMergeRequest('4');

	// var_dump($merge_changes);

	$unique_features = $gitlab->getUniqueBranchFeatures('beta', 'master');
	// var_dump($unique_features);
	$feature_list = $gitlab->getAllBranchMergedFeatures('beta');
?>

<link href="assets/css/app.css" rel="stylesheet">
<!-- <script src="assets/js/app.js"></script> -->

<div class="container my-5">
	<div class="row">
		<div class="col">
			<h6>Using The GitLab API Wrapper</h6>

			<figure class="highlight">
				<code class="language-html" data-lang="html">
					<p>use Library\GitLab;</p>
					<p>$gitlab = new GitLab;</p>
				</code>
			</figure>

			<b>Parameters</b>
			<p>string $token (optional)</p>
			<p>string $base_uri (optional)</p>
			<p>string $project_id (optional)</p>
			<p>*Note: You should handle the token inside the class and pull it from a non version controlled file. However you do have the option to pass it in.</p>
		</div>
	</div>
</div>

<hr />

<div class="container my-5">
	<div class="row">
		<div class="col my-3">
			<h6>Get All Projects</h6>
			<p>Grab all the projects that the authenticated user is a member of.</p>
			<figure class="highlight">
				<code class="language-html" data-lang="html">
					<p>$gitlab->getProjects()</p>
				</code>
			</figure>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<table class="table">
				<thead>
					<tr>
						<th>ID</th>
						<th>URL</th>
						<th>NAME</th>
						<th>PATH</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($projects as $project): ?>
						<tr>
							<td><?= $project->id ?></td>
							<td><?= $project->web_url ?></td>
							<td><?= $project->name ?></td>
							<td><?= $project->path_with_namespace ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<hr />

<div class="container my-5">
	<div class="row">
		<div class="col my-3">
			<h6>Get All Merge Requests</h6>
			<p>Returns all the merge requests.</p>
			<figure class="highlight">
				<code class="language-html" data-lang="html">
					<p>$gitlab->getAllRepositoryMergeRequests()</p>
				</code>
			</figure>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<table class="table">
				<thead>
					<tr>
						<th>ID</th>
						<th>IID</th>
						<th>Title</th>
						<th>Source Branch</th>
						<th>Target Branch</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($merges as $merge): ?>
						<tr>
							<td><?= $merge->id ?></td>
							<td><?= $merge->iid ?></td>
							<td><?= $merge->title ?></td>
							<td><?= $merge->source_branch ?></td>
							<td><?= $merge->target_branch ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<hr />

<div class="container my-5">
	<div class="row">
		<div class="col">
			<h6>Accepting a Merge Request</h6>

			<figure class="highlight">
				<code class="language-html" data-lang="html">
					<p>$gitlab->acceptMergeRequest(string $merge_request_iid, array $params = [])</p>
				</code>
			</figure>

			<b>Parameters</b>
			<p>string $merge_request_iid (required)</p>
			<p>string $params (optional) - See <a href="https://docs.gitlab.com/ee/api/merge_requests.html#accept-mr">Accept MR</a> for full list.</p>
		</div>
	</div>
</div>

<hr />

<div class="container my-5">
	<div class="row">
		<div class="col">
			<h6>Delete a Merge Request</h6>

			<figure class="highlight">
				<code class="language-html" data-lang="html">
					<p>$gitlab->deleteMergeRequest(string $merge_request_iid)</p>
				</code>
			</figure>

			<b>Parameters</b>
			<p>string $merge_request_iid (required)</p>
		</div>
	</div>
</div>

<hr />

<div class="container my-5">
	<div class="row">
		<div class="col">
			<h6>Get Unique Branch Features</h6>

			<figure class="highlight">
				<code class="language-html" data-lang="html">
					<p>$gitlab->getUniqueBranchFeatures('beta', 'master')</p>
				</code>
			</figure>

			<b>Parameters</b>
			<p>string $base (required)</p>
			<p>string $compare (required)</p>
		</div>
	</div>

	<div class="row my-2">
		<div class="col">
			<table class="table">
				<thead>
					<tr>
						<th>Branch</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($unique_features as $feature): ?>
						<tr>
							<td><?= $feature ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<hr />

<div class="container my-5">
	<div class="row">
		<div class="col">
			<h6>Get All Merged Branches</h6>

			<figure class="highlight">
				<code class="language-html" data-lang="html">
					<p>$gitlab->getAllBranchMergedFeatures('beta')</p>
				</code>
			</figure>

			<b>Parameters</b>
			<p>string $branch (required)</p>
		</div>
	</div>

	<div class="row my-2">
		<div class="col">
			<table class="table">
				<thead>
					<tr>
						<th>Branch</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($feature_list as $feature): ?>
						<tr>
							<td><?= $feature ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<hr />

<div class="container my-5">
	<div class="row">
		<div class="col">
			<h6>Delete All Merged Features</h6>
			<p>Delete all feature branches that are merged into the project's default branch.</p>

			<figure class="highlight">
				<code class="language-html" data-lang="html">
					<p>$gitlab->deleteAllMergedFeatures()</p>
				</code>
			</figure>
		</div>
	</div>
</div>

<hr />

<div class="container my-5">
	<div class="row">
		<div class="col">
			<h6>Get Merge Changes</h6>

			<figure class="highlight">
				<code class="language-html" data-lang="html">
					<p>$gitlab->getMergeChanges(string $merge_request_iid);</p>
				</code>
			</figure>

			<b>Parameters</b>
			<p>string $merge_request_iid (required)</p>
		</div>
	</div>

	<?php foreach ($merge_changes->changes as $merge_diff): ?>
		<div class="row my-2">
			<div class="col">
				<div class="card">
				    <div class="card-body">
				    	<pre>
					        <?php
					        	echo <<<EOF
					        	<font color="#cc0000">
					        		$merge_diff->diff
								</font>
EOF;
			        		?>
			        	</pre>
					</div>
			    </div>
			</div>
		</div>
	<?php endforeach; ?>
</div>
