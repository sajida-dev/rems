<?php include_once("components/header.php");
require_once "backend/single_property.php";
?>

<section class="hero-wrap hero-wrap-2 ftco-degree-bg js-fullheight" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
	<div class="overlay"></div>
	<div class="container">
		<div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
			<div class="col-md-9 ftco-animate pb-5 text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Properties <i class="ion-ios-arrow-forward"></i></span></p>
				<h1 class="mb-3 bread"><?php echo htmlspecialchars($property['title']); ?></h1>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section ftco-property-details">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="property-details">
					<!-- Display the property image as a background -->
					<div class="img" style="background-image: url(<?php echo htmlspecialchars($property['image_url']); ?>);"></div>
					<div class="text text-center">
						<!-- Display location and title -->
						<span class="subheading"><?php echo htmlspecialchars($property['location']); ?></span>
						<h2><?php echo htmlspecialchars($property['title']); ?></h2>
					</div>
				</div>
			</div>
		</div>
		<!-- Tabbed Content for Features and Description -->
		<div class="row">
			<div class="col-md-12 pills">
				<div class="bd-example bd-example-tabs">
					<div class="d-flex justify-content-center">
						<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="pills-description-tab" data-toggle="pill" href="#pills-description" role="tab" aria-controls="pills-description" aria-expanded="true">Features</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pills-manufacturer-tab" data-toggle="pill" href="#pills-manufacturer" role="tab" aria-controls="pills-manufacturer" aria-expanded="true">Description</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pills-images-tab" data-toggle="pill" href="#pills-images" role="tab" aria-controls="pills-images" aria-expanded="true">Images</a>
							</li>
						</ul>
					</div>
					<div class="tab-content" id="pills-tabContent">
						<!-- Features Tab -->
						<div class="tab-pane fade show active" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab">
							<div class="row">
								<div class="col-md-4">
									<ul class="features">
										<li class="check"><span class="ion-ios-checkmark"></span>Lot Area: <?php echo htmlspecialchars($property['area']); ?> SQ FT</li>
										<li class="check"><span class="ion-ios-checkmark"></span>Floor Area: <?php echo htmlspecialchars($property['area']); ?> SQ FT</li>
										<li class="check"><span class="ion-ios-checkmark"></span>Bed Rooms: <?php echo htmlspecialchars($property['bedrooms']); ?></li>
										<li class="check"><span class="ion-ios-checkmark"></span>Bath Rooms: <?php echo htmlspecialchars($property['bathrooms']); ?></li>

										<li class="check"><span class="ion-ios-checkmark"></span>Garage: 2</li>
									</ul>
								</div>
								<div class="col-md-4">
									<ul class="features">

										<li class="check"><span class="ion-ios-checkmark"></span>Year Built: 2019</li>
										<li class="check"><span class="ion-ios-checkmark"></span>Water: Yes</li>
										<li class="check"><span class="ion-ios-checkmark"></span>Stories: 2</li>
										<li class="check"><span class="ion-ios-checkmark"></span>Roofing: New</li>
										<li class="check"><span class="ion-ios-checkmark"></span>Luggage</li>
									</ul>
								</div>
								<div class="col-md-4">

									<ul class="features">
										<?php $features = explode(",", $property['amenity_list'], 5);
										foreach ($features as $feature):
										?>
											<li class="check">
												<span class="ion-ios-checkmark"></span>
												<?php echo $feature; ?>
											</li>
										<?php endforeach; ?>

									</ul>
								</div>
							</div>
						</div>
						<!-- Description Tab -->
						<div class="tab-pane fade" id="pills-manufacturer" role="tabpanel" aria-labelledby="pills-manufacturer-tab">
							<p><?php echo htmlspecialchars($property['description']); ?></p>
						</div>
						<div class="tab-pane fade" id="pills-images" role="tabpanel" aria-labelledby="pills-images-tab">
							<div class="gallery">
								<?php if (!empty($images)): ?>
									<?php foreach ($images as $img): ?>
										<div class="gallery-item">
											<img src="<?php echo htmlspecialchars($img['image_url']); ?>" alt="Property Image">
										</div>
									<?php endforeach; ?>
								<?php else: ?>
									<p>No images available.</p>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php include_once "components/footer.php" ?>

<script>
	$(document).ready(function() {
		$('#pills-tab a').on('click', function(e) {
			e.preventDefault();
			var hash = this.hash;
			$(this).tab('show');

			if (history.pushState) {
				history.pushState(null, null, hash);
			} else {
				window.location.hash = hash;
			}
		});
	});
</script>