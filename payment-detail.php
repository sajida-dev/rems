 <div class="mt-6 grow sm:mt-8 lg:mt-0">
     <div class="space-y-4 rounded-lg border border-gray-100 bg-gray-50 p-6 ">
         <div class="space-y-2">

             <dl class="flex items-center justify-between gap-4">
                 <dt class="text-base font-normal text-gray-500 ">Property</dt>
                 <dd class="text-base font-medium text-gray-900 "><?php echo $property['title'] ?? "?" ?></dd>
             </dl>

             <dl class="flex items-center justify-between gap-4">
                 <dt class="text-base font-normal text-gray-500 ">Agent</dt>
                 <dd class="text-base font-medium text-gray-900 "><?php echo $property['name'] ?? "?" ?></dd>
             </dl>
             <dl class="flex items-center justify-between gap-4">
                 <dt class="text-base font-normal text-gray-500 ">Original Old price</dt>
                 <dd class="text-base font-medium text-gray-900 ">$<?php echo $property['old_price'] ?? "?" ?></dd>
             </dl>

             <dl class="flex items-center justify-between gap-4">
                 <dt class="text-base font-normal text-gray-500 ">Rent Price</dt>
                 <dd class="text-base font-medium text-green-500">$<?php echo $property['rent_price'] ?? "?" ?></dd>
             </dl>


         </div>

         <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 ">
             <dt class="text-base font-bold text-gray-900 ">Total</dt>
             <dd class="text-base font-bold text-gray-900 ">$<?php echo $amount ?></dd>
         </dl>
     </div>

     <div class="mt-6 flex items-center justify-center gap-8">
         <img class="h-8 w-auto " src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/paypal.svg" alt="" />
         <img class="hidden h-8 w-auto " src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/paypal-dark.svg" alt="" />
         <img class="h-8 w-auto " src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/visa.svg" alt="" />
         <img class="hidden h-8 w-auto " src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/visa-dark.svg" alt="" />
         <img class="h-8 w-auto " src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/mastercard.svg" alt="" />
         <img class="hidden h-8 w-auto " src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/mastercard-dark.svg" alt="" />
     </div>
 </div>