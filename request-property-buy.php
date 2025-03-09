<?php
$title = "Request Buy";
require_once "backend/save-payment.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Buy Property</title>
    <style>
        .custom-buy-btn {
            background-color: rgb(227, 62, 131);
        }

        .custom-buy-btn:focus,
        .custom-buy-btn:hover {
            background: none;
            border: 1.5px solid rgb(227, 62, 131);
            color: rgb(227, 62, 131);
            transition: ease-in-out;
            transition-duration: 0.5s;
        }
    </style>
</head>

<body>

    <section class="bg-white py-8 antialiased  md:py-16">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div class="mx-auto max-w-5xl">
                <h2 class="text-xl font-semibold text-gray-900  sm:text-2xl">Payment</h2>

                <div class="mt-6 sm:mt-8 lg:flex lg:items-start lg:gap-12">
                    <form action="" method="POST" class="w-full rounded-lg border border-gray-200 bg-white p-4 shadow-sm 0 sm:p-6 lg:max-w-xl lg:p-8">
                        <input type="hidden" name="property_id" value="<?php echo htmlspecialchars($_GET['id']); ?>">

                        <div class="mb-6 grid grid-cols-2 gap-4">
                            <div class="col-span-2 sm:col-span-1">
                                <label for="full_name" class="mb-2 block text-sm font-medium text-gray-900 "> Full name <small>(as displayed on card)*</small> </label>
                                <input type="text" id="full_name" name="full_name" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 " placeholder="Bonnie Green" required />
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="card-number-input" class="mb-2 block text-sm font-medium text-gray-900 "> Card number* <small>(without dashes)</small></label>
                                <input type="text" id="card-number-input" name="card_number" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 pe-10 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500  " placeholder="xxxx-xxxx-xxxx-xxxx" pattern="^4[0-9]{12}(?:[0-9]{3})?$" required />
                            </div>

                            <div>
                                <label for="card-expiration-input" class="mb-2 block text-sm font-medium text-gray-900 ">Card expiration* </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
                                        <svg class="h-4 w-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                fill-rule="evenodd"
                                                d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input datepicker name="card_expiration" datepicker-format="mm/yy" id="card-expiration-input" type="text" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-9 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 " placeholder="12/23" required />
                                </div>
                            </div>
                            <div>
                                <label for="cvv-input" class="mb-2 flex items-center gap-1 text-sm font-medium text-gray-900 ">
                                    CVV*
                                    <button data-tooltip-target="cvv-desc" data-tooltip-trigger="hover" class="text-gray-400 hover:text-gray-900 ">
                                        <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div id="cvv-desc" role="tooltip" class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium  opacity-0 shadow-sm transition-opacity duration-300">
                                        The last 3 digits on back of card
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </label>
                                <input type="number" id="cvv-input" name="card_cvv" aria-describedby="helper-text-explanation" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 " placeholder="•••" required />
                            </div>
                        </div>

                        <button type="submit" class="custom-buy-btn flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium hover:bg-primary-800 focus:outline-none focus:ring-4 text-white focus:ring-primary-300 ">Pay now</button>
                    </form>

                    <?php require_once "payment-detail.php"; ?>
                </div>


            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>

</body>

</html>