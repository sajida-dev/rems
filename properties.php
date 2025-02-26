<?php require_once("components/header.php");
if ($conMessage):
	require_once("backend/select_properties.php");
endif;
?>

<section class="hero-wrap hero-wrap-2 ftco-degree-bg js-fullheight" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
	<div class="overlay"></div>
	<div class="container">
		<div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
			<div class="col-md-9 ftco-animate pb-5 text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Properties <i class="ion-ios-arrow-forward"></i></span></p>
				<h1 class="mb-3 bread">Choose <br>Your Desired Home</h1>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section">
	<div class="container">
		<?php if ($message): ?>
			<div class="row">

				<?php

				foreach ($properties as $property):
				?>
					<div class="col-md-4">
						<div class="property-wrap ftco-animate">
							<a href="properties-single.php?id=<?php echo $property['id']; ?>" class="img" style="background-image: url(<?php echo $property['image_url'] ?>);"></a>
							<div class="text">
								<p class="price"><span class="old-price">$<?php echo number_format($property['old_price']) ?></span><span class="orig-price">$<?php echo number_format($property['rent_price']) ?><small>/mo</small></span></p>
								<ul class="property_list">
									<li>
										<span class="flaticon-bed"></span>
										<?php echo $property['bedrooms'] ?>
									</li>
									<li><span class="flaticon-bathtub"></span>
										<?php echo $property['bathrooms'] ?>
									</li>
									<li><span class="flaticon-floor-plan"></span>
										<?php echo $property['area'] ?> sqft
									</li>
								</ul>
								<h3><a href="properties-single.php?id=<?php echo $property['id']; ?>">
										<?php echo htmlspecialchars($property['title']) ?>
									</a>
								</h3>
								<span class="location">
									<?php echo htmlspecialchars($property['location']) ?>
								</span>
								<a href="properties-single.php?id=<?php echo $property['id']; ?>" class="d-flex align-items-center justify-content-center btn-custom">
									<span class="ion-ios-link"></span>
								</a>
							</div>
						</div>
					</div>
				<?php
				endforeach;

				?>
			</div>
			<div class="row mt-5">
				<div class="col text-center">
					<div class="block-27">
						<ul>
							<!-- Previous Link -->
							<?php if ($page > 1): ?>
								<li><a href="properties.php?page=<?php echo $page - 1; ?>">&lt;</a></li>
							<?php else: ?>
								<li class="disabled"><span>&lt;</span></li>
							<?php endif; ?>

							<!-- Page Number Links -->
							<?php for ($i = 1; $i <= $total_pages; $i++): ?>
								<?php if ($i == $page): ?>
									<li class="active"><span><?php echo $i; ?></span></li>
								<?php else: ?>
									<li><a href="properties.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
								<?php endif; ?>
							<?php endfor; ?>

							<!-- Next Link -->
							<?php if ($page < $total_pages): ?>
								<li><a href="properties.php?page=<?php echo $page + 1; ?>">&gt;</a></li>
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