<?php
require_once "backend/single_property.php";
$title = htmlspecialchars($property['title']);
include_once("components/header.php");
?>
<style>
	.btn-custom {
		display: inline-block;
		padding: 10px 20px;
		text-decoration: none;
		font-size: 16px;
		border-radius: 4px;
		transition: background-color 0.3s ease, transform 0.2s ease;
		font-weight: 600;
	}

	.btn-custom i {
		margin-right: 8px;
	}

	/* Buy Now Button Styles */
	.btn-buy {
		background-color: rgb(255, 97, 221);
		color: #fff;
		border: none;
	}

	.btn-buy:hover {
		transform: scale(1.03);
		border: 1px solid rgb(255, 97, 221);
		background: none;
	}

	#map {
		height: 400px;
		width: 100%;
	}

	.modal-body {
		position: relative;
		display: flex;
		justify-content: center;
		align-items: center;
		height: 100vh;

	}

	.modal-dialog {
		max-width: 100%;
		height: 100%;
		margin: 0;
		padding: 0;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.modal-content {
		width: 100%;
		height: 100%;
		border-radius: 0;
		display: flex;
		flex-direction: column;
	}

	#prevBtn,
	#nextBtn {
		position: absolute;
		top: 50%;
		transform: translateY(-50%);
		z-index: 1000;
		background-color: rgba(0, 0, 0, 0.5);
		border: none;
		/* padding: 15px; */
		/* color: #fff; */
		font-size: 25px;
		border-radius: 50%;
		cursor: pointer;
		transition: background-color 0.3s ease;
	}


	#prevBtn {
		left: 20px;
	}

	#nextBtn {
		right: 20px;
	}

	#prevBtn:hover,
	#nextBtn:hover {
		background-color: rgba(0, 0, 0, 0.7);
	}

	#modalImage {
		width: 100%;
		max-height: 100vh;
		object-fit: contain;
	}
</style>

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
					<div class="img" style="background-image: url(<?php echo "dashboard/" . htmlspecialchars($property['image_url']); ?>);"></div>
					<div class="text text-center">
						<!-- Display location and title -->
						<span class="subheading"><?php echo htmlspecialchars($property['location']); ?></span>
						<h2><?php echo htmlspecialchars($property['title']); ?></h2>
						<a href="request-property-buy.php?id=<?= $property['id'] ?>" class="btn-custom btn-buy">
							<i class="fas fa-shopping-cart"></i> Buy Now
						</a>
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
							<div id="map"></div>
						</div>
						<!-- Description Tab -->
						<div class="tab-pane fade" id="pills-manufacturer" role="tabpanel" aria-labelledby="pills-manufacturer-tab">
							<p><?php echo htmlspecialchars($property['description']); ?></p>
						</div>
						<div class="tab-pane fade" id="pills-images" role="tabpanel" aria-labelledby="pills-images-tab">

							<div class="gallery">
								<div class="row">
									<?php if (!empty($images)): ?>
										<?php foreach ($images as $index => $img): ?>
											<div class="col-6 col-sm-4 col-lg-3 mb-4">
												<div class="image-container">
													<a href="#" data-toggle="modal" data-target="#imageModal" class="image-link" data-image="<?php echo "dashboard/" . htmlspecialchars($img['image_url']); ?>" data-index="<?php echo $index; ?>">
														<img src="<?php echo "dashboard/" . htmlspecialchars($img['image_url']); ?>" alt="Property Image" class="img-fluid rounded">
													</a>
												</div>
											</div>
										<?php endforeach; ?>
									<?php else: ?>
										<p>No images available.</p>
									<?php endif; ?>
								</div>
							</div>

							<!-- Modal for Image View -->
							<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
									<div class="modal-content">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 10px; top: 10px; z-index:1000">
											<span aria-hidden="true">&times;</span>
										</button>

										<div class="modal-body d-flex justify-content-center align-items-center">
											<button type="button" class="btn btn-secondary" id="prevBtn" disabled>
												<i class="ion-ios-arrow-back"></i>
											</button>

											<img src="" alt="Full Image" id="modalImage" class="img-fluid">

											<button type="button" class="btn btn-secondary" id="nextBtn" disabled>
												<i class="ion-ios-arrow-forward"></i>
											</button>
										</div>
									</div>
								</div>
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

	let map;

	function initMap() {
		map = new google.maps.Map(document.getElementById("map"), {
			center: {
				lat: -34.397,
				lng: 150.644
			},
			zoom: 8,
		});
	}

	$(document).ready(function() {
		let currentIndex = 0;
		let images = <?php echo json_encode($images); ?>;
		let totalImages = images.length;

		$(".image-link").click(function(e) {
			e.preventDefault();
			currentIndex = $(this).data('index');
			loadImage(currentIndex);
			$('#imageModal').modal('show');
		});

		function loadImage(index) {
			const imageUrl = "dashboard/" + images[index].image_url;
			$('#modalImage').attr('src', imageUrl);

			if (index === 0) {
				$('#prevBtn').prop('disabled', true);
			} else {
				$('#prevBtn').prop('disabled', false);
			}

			if (index === totalImages - 1) {
				$('#nextBtn').prop('disabled', true);
			} else {
				$('#nextBtn').prop('disabled', false);
			}
		}

		$('#nextBtn').click(function() {
			if (currentIndex < totalImages - 1) {
				currentIndex++;
				loadImage(currentIndex);
			}
		});

		$('#prevBtn').click(function() {
			if (currentIndex > 0) {
				currentIndex--;
				loadImage(currentIndex);
			}
		});
	});
</script>