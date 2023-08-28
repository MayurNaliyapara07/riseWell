<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        [hidden],
        [x-cloak] {
            display: none !important;
        }
        .font-sans {
            font-family: "Inter var",system-ui,-apple-system,"Segoe UI",Roboto,Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji";
        }
    </style>
</head>

<body>
<div class="grid place-items-center w-screen h-screen p-4 bg-gray-50 dark:bg-gray-900">
    <form id="payment-form" class="max-w-md mx-auto" autocomplete="off" action="{{route('subscription')}}" method="post">
        @csrf
        <div class="grid grid-cols-3 gap-6">

            <input type="hidden" name="product_id" value="{{!empty($data)?$data['product_id']:''}}" />

            <label for="cc" class="relative block w-full col-span-3">
                <span class="text-sm font-medium leading-normal text-gray-700 dark:text-gray-200">Card Name</span>
                <p class="py-1 text-xs leading-normal text-gray-600 dark:text-gray-400">As a user types, the number should be formatted with spaces for legibility based on the pattern the type of card uses.</p>
                <input type="text" name="" id="card-holder-name" placeholder="" autocomplete="false"  class="appearance-none outline-none relative block w-full h-11 mt-2 px-3 py-2.5 text-base font-mono font-medium leading-normal tracking-wider border rounded transition duration-150 ease-in-out border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-50 bg-white dark:bg-gray-800 focus-visible:ring-inset focus-visible:ring-1 focus-visible:ring-[#1e90ff] dark:focus-visible:ring-[#ffd700] focus-visible:text-gray-700 focus-visible:bg-indigo-50 dark:focus-visible:text-gray-100 dark:focus-visible:bg-indigo-600/10 focus-visible:border-[#1e90ff] dark:focus-visible:border-[#ffd700] focus-visible:shadow-inner hover:border-gray-500 dark:hover:bg-black/10" />
                <span class="absolute top-0 right-0 block text-sm font-medium tracking-wider text-blue-600 dark:text-amber-300"></span>
            </label>
            <div id="card-element" class="relative block w-full col-span-3"></div>
            <div>
                <button type="submit"  id="card-button" data-secret="{{ $intent->client_secret }}" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Pay</button>
            </div>
        </div>
    </form>
</div>
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ $stripeKey }}');
    const elements = stripe.elements();
    const card = elements.create("card");
    card.mount("#card-element");
    const cardHolderName = document.getElementById('name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;
    card.on('change', ({error}) => {
        let displayError = document.getElementById('card-errors');
        if (error) {
            displayError.textContent = error.message;
        } else {
            displayError.textContent = '';
        }
    });
    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        let displayError = document.getElementById('card-errors');

        const { setupIntent, error } = await stripe.confirmCardSetup(
            clientSecret, {
                payment_method: {
                    card: card,
                }
            }
        );

        if (error) {

        } else {
            console.log(setupIntent.payment_method,'asss')
            displayError.textContent = '';

            let paymentMethod = document.createElement('input');
            paymentMethod.setAttribute('type', 'hidden');
            paymentMethod.setAttribute('name', 'payment_method');
            paymentMethod.value = setupIntent.payment_method;

            form.appendChild(paymentMethod);
            form.submit();
        }
    });
</script>
</body>
</html>



