<?php
session_start();

include 'commons.php';

$services = send('GET', '/services');

?>

<!doctype html>
<html class="no-js" lang="">

<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>Ataccama Task</title>
<meta name="description"
	content="A competition by Ataccama which requires contestants to write the shortest possible codes.">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="icon" type="image/png" href="./img/favicon.png" sizes="32x32">

<script src="https://code.jquery.com/jquery-3.2.1.min.js"
	integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
	crossorigin="anonymous"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
	integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
	crossorigin="anonymous"></script>
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
	integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb"
	crossorigin="anonymous">
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
	integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
	crossorigin="anonymous"></script>

<script src="./ace-builds-1.2.9/src/ace.js"></script>

<script src="./ezbsalert.js"></script>
<link rel="stylesheet" href="./main.css?v=1">
<script type="text/javascript" src="./script.js?v=1"></script>
</head>

<body>
	<div class="container-fluid">
		<div class="row header">
			<div class="col-md-4 logo">
				<img src="./img/ataccama-logo-purple.png" />
			</div>
			<div class="col-md-8 motto">
				<h1>Short Programming Tasks</h1>
			</div>
		</div>
		<div class="row content">
			<div class="col-lg-8">
				<h2>Tasks</h2>

				<div id="tasks" role="tablist">
					<div class="card">
						<div class="card-header" role="tab" id="headingIntro">
							<h5 class="mb-0">
								<a data-toggle="collapse" href="#collapseIntro"
									aria-expanded="true" aria-controls="collapseIntro">
									Introduction</a>
							</h5>
						</div>

						<div id="collapseIntro" class="collapse show" role="tabpanel"
							aria-labelledby="headingIntro" data-parent="#tasks">
							<div class="card-body intro">
								<p>Your goal is to solve tasks by submitting pieces of code. You
									might have seen some of the tasks already, but we gave them a
									twist to make them more entertaining. Each task is going to
									have a winner and an award for the best (shortest) submission.</p>
								<p>You can submit as many solutions to each task as you desire.
									Each submission is graded independently. The list of your
									submissions is stored in session, so you might want back them
									up. Submissions are kept secret until the end of the
									competition, which is at midnight.</p>
								<p>In order to participate, you must provide an email address.
									It is will only be used to inform you about the best solutions
									and submission statistics, and to announce the winners.</p>
								<p>Good luck!</p>
								<form>
									<div class="form-group">
										<label for="email" class="emailLabel">Email address:</label> <input
											type="email" class="form-control" id="email"
											aria-describedby="emailHelp" placeholder="Enter email"
											value="<?= $_SESSION['email'] ?>">
									</div>
								</form>
							</div>
						</div>
					</div>

<?php
foreach ($services->tasks as $task) {
    ?>
					<div class="card task" id="task-<?= $task->id ?>"
						data-task-id="<?= $task->id ?>">
						<div class="card-header" role="tab"
							id="task-heading-<?= $task->id ?>">
							<h5 class="mb-0">
								<a class="collapsed" data-toggle="collapse"
									href="#task-body-<?= $task->id ?>" aria-expanded="false"
									aria-controls="task-body-<?= $task->id ?>"><?= $task->name ?></a>
							</h5>
						</div>
						<div id="task-body-<?= $task->id ?>" class="collapse"
							role="tabpanel" aria-labelledby="task-heading-<?= $task->id ?>"
							data-parent="#tasks">
							<div class="card-body">
								<div class="task-description">
									<p><?= $task->description ?></p>
								</div>
								<form id="form-<?= $task->id ?>">
									<div class="form-group task-language">
										<label for="task-language-<?= $task->id ?>">Select language:</label>
										<select class="form-control"
											id="task-language-<?= $task->id ?>">
<?php foreach ($services->languages as $language) {?>
											<option value="<?= $language->id ?>">
												<?= $language->name ?>: <?= $language->description ?>
											</option>
<?php } ?>
										</select>
									</div>

									<div class="form-group code">
										<label class="textAreaLabel" for="editor-<?= $task->id ?>">Type
											your code here:</label>
										<div class="editor" id="task-editor-<?= $task->id ?>"></div>
										<p>
											Your code is using <span class="task-count">0</span>
											characters.
										</p>
									</div>
									<button type="submit" class="btn btn-primary submit"
										id="task-submit-<?= $task->id ?>">Submit solution</button>
								</form>
							</div>
						</div>
					</div>
<?php } ?>
				</div>
			</div>
			<div class="col-lg-4">
				<h2>Submissions</h2>

				<div id="submissions" role="tablist">
<?php
$submissions = fetchSubmissions($_SESSION['all']);
if (empty($submissions)) {
    ?>
					<p class="empty">You don't have any submissions</p>
<?php
} else {
    printSubmissions($submissions);
}
?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>