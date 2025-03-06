<?php require_once("components/header.php");
if ($conMessage):
	require_once("backend/select_agents.php");
endif;
?>

<style>
	.custom-img {
		height: 300px;
		overflow: hidden;
	}
</style>

<section class="hero-wrap hero-wrap-2 ftco-degree-bg js-fullheight" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
	<div class="overlay"></div>
	<div class="container">
		<div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
			<div class="col-md-9 ftco-animate pb-5 text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Agent <i class="ion-ios-arrow-forward"></i></span></p>
				<h1 class="mb-3 bread">Agent</h1>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section ftco-agent">
	<div class="container">
		<?php if ($message): ?>
			<div class="row">
				<?php foreach ($agents as $agent): ?>
					<div class="col-md-3">
						<div class="agent">
							<div class="img custom-img">
								<img src="<?php echo !empty($agent['profile_pic']) ? "dashboard/" . $agent['profile_pic'] : 'images/default-agent.jpg'; ?>" class="img-fluid" alt="Agent Image">
							</div>
							<div class="desc">
								<h3>
									<!-- Link to properties page filtered by agent -->
									<a href="single-agent.php?agent_id=<?php echo $agent['id']; ?>">
										<?php echo htmlspecialchars($agent['name']); ?>
									</a>
								</h3>
								<p class="h-info">
									<span class="location">Listing</span>
									<span class="details">&mdash; <?php echo $agent['property_count']; ?> Properties</span>
								</p>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="row mt-5">
				<div class="col text-center">
					<div class="block-27">
						<ul>
							<!-- Previous Link -->
							<?php if ($page > 1): ?>
								<li><a href="agent.php?agent_page=<?php echo $page - 1; ?>">&lt;</a></li>
							<?php else: ?>
								<li class="disabled"><span>&lt;</span></li>
							<?php endif; ?>

							<!-- Page Number Links -->
							<?php for ($i = 1; $i <= $total_pages; $i++): ?>
								<?php if ($i == $page): ?>
									<li class="active"><span><?php echo $i; ?></span></li>
								<?php else: ?>
									<li><a href="agent.php?agent_page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
								<?php endif; ?>
							<?php endfor; ?>

							<!-- Next Link -->
							<?php if ($page < $total_pages): ?>
								<li><a href="agent.php?agent_page=<?php echo $page + 1; ?>">&gt;</a></li>
							<?php else: ?>
								<li class="disabled"><span>&gt;</span></li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
			</div>
		<?php else: ?>
			<div class="col-12">
				<div class="alert alert-info text-center">
					<?php echo $message; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php include_once "components/footer.php" ?>