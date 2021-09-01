<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subscription') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- This example requires Tailwind CSS v2.0+ -->
            <div class="bg-white">
                <div class="max-w-7xl mx-auto py-24 px-4 sm:px-6 lg:px-8">
                    <div class="sm:flex sm:flex-col sm:align-center">
                        <h1 class="text-5xl font-extrabold text-gray-900 sm:text-center">Support Plans</h1>
                        <p class="mt-5 text-xl text-gray-500 sm:text-center">Let us provide you with all the support you need. Choose the plan that fits you.</p>
                        {{-- <div class="relative self-center mt-6 bg-gray-100 rounded-lg p-0.5 flex sm:mt-8">
                            <button type="button" class="relative w-1/2 bg-white border-gray-200 rounded-md shadow-sm py-2 text-sm font-medium text-gray-900 whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:z-10 sm:w-auto sm:px-8">Monthly billing</button>
                            <button type="button" class="ml-0.5 relative w-1/2 border border-transparent rounded-md py-2 text-sm font-medium text-gray-700 whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:z-10 sm:w-auto sm:px-8">Yearly billing</button>
                        </div> --}}
                    </div>
                    <div class="mt-12 space-y-4 sm:mt-16 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-6 lg:max-w-4xl lg:mx-auto xl:max-w-none xl:mx-0 xl:grid-cols-4">
                        <div class="border @if (Auth::user()->onProduct('prod_K7kDWYmH0opBRP')) {{ 'border-indigo-600' }} @else  {{ 'border-gray-200' }} @endif rounded-lg shadow-sm divide-y divide-gray-200 lg:col-start-2">
                            <div class="p-6">
                                <h2 class="text-lg leading-6 font-medium text-gray-900">Basic</h2>
                                <p class="mt-4 text-sm text-gray-500">Call us during office hours.</p>
                                <p class="mt-8">
                                    <span class="text-4xl font-extrabold text-gray-900">{{ Auth::user()->basicAmount() }}</span>
                                    <span class="text-base font-medium text-gray-500">/mo</span>
                                </p>

                                @if (Auth::user()->onProduct('prod_K7kDWYmH0opBRP'))
                                    <div class="mt-8 block w-full bg-indigo-600 border border-indigo-600 rounded-md py-2 text-sm font-semibold text-white text-center">Active</div>
                                @elseif (Auth::user()->subscribed())
                                    <a href="{{ route('swap', 'price_1JTUio4MjUVeuXeNbZoeBDKy') }}" class="mt-8 block w-full bg-gray-800 border border-gray-800 rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-gray-900">Downgrade to Basic</a>
                                    <a href="{{ route('invoice.upcoming', 'price_1JTUio4MjUVeuXeNbZoeBDKy') }}" class="mt-2 block w-full bg-white border border-gray-800 rounded-md py-2 text-sm font-semibold text-gray-900 text-center hover:bg-gray-50">Preview Invoice</a>
                                @elseif (Auth::user()->hasOrders())
                                    <a href="{{ route('subscribe.custom') }}" class="mt-8 block w-full bg-gray-800 border border-gray-800 rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-gray-900">Get Basic</a>
                                @else
                                    <a href="{{ route('subscribe', 'price_1JTUio4MjUVeuXeNbZoeBDKy') }}" class="mt-8 block w-full bg-gray-800 border border-gray-800 rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-gray-900">Get Basic</a>
                                @endif
                            </div>
                        </div>

                        <div class="border @if (Auth::user()->onProduct('prod_K7kEgxfHlPEwlk')) {{ 'border-indigo-600' }} @else  {{ 'border-gray-200' }} @endif rounded-lg shadow-sm divide-y divide-gray-200">
                            <div class="p-6">
                                <h2 class="text-lg leading-6 font-medium text-gray-900">Premium</h2>
                                <p class="mt-4 text-sm text-gray-500">Reach us 24/7.</p>
                                <p class="mt-8">
                                    <span class="text-4xl font-extrabold text-gray-900">€9.99</span>
                                    <span class="text-base font-medium text-gray-500">/mo</span>
                                </p>

                                @if (Auth::user()->onProduct('prod_K7kEgxfHlPEwlk'))
                                    <div class="mt-8 block w-full bg-indigo-600 border border-indigo-600 rounded-md py-2 text-sm font-semibold text-white text-center">Active</div>
                                @elseif (Auth::user()->subscribed())
                                    <a href="{{ route('swap', 'price_1JTUkV4MjUVeuXeN422i3zAY') }}" class="mt-8 block w-full bg-gray-800 border border-gray-800 rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-gray-900">Upgrade to Premium</a>
                                    <a href="{{ route('invoice.upcoming', 'price_1JTUkV4MjUVeuXeN422i3zAY') }}" class="mt-2 block w-full bg-white border border-gray-800 rounded-md py-2 text-sm font-semibold text-gray-900 text-center hover:bg-gray-50">Preview Invoice</a>
                                @else
                                    <a href="{{ route('subscribe', 'price_1JTUkV4MjUVeuXeN422i3zAY') }}" class="mt-8 block w-full bg-gray-800 border border-gray-800 rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-gray-900">Go Premium</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if (count($invoices))
                        <div class="lg:max-w-xl lg:mx-auto mt-10">
                            <div class="pb-5 border-b border-gray-200">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Invoices
                                </h3>
                            </div>

                            <div class="flow-root mt-6">
                                <ul role="list" class="-my-5 divide-y divide-gray-200">
                                    @isset ($upcomingInvoice)
                                        <li class="py-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">
                                                        Upcoming invoice
                                                    </p>
                                                    <p class="text-sm text-gray-500 truncate">
                                                        {{ $upcomingInvoice->date()->format('F j, Y') }}
                                                    </p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    {{ $upcomingInvoice->total() }}
                                                </div>
                                                <div>
                                                    <a href="{{ route('invoice.upcoming') }}" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                                        Preview
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endif

                                    @foreach ($invoices as $invoice)
                                        <li class="py-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">
                                                        {{ $invoice->date()->format('F j, Y') }}
                                                    </p>
                                                    {{-- <p class="text-sm text-gray-500 truncate">
                                                        {{ $invoice->date()->format('F j, Y') }}
                                                    </p> --}}
                                                </div>
                                                <div class="flex-shrink-0">
                                                    {{ $invoice->total() }}
                                                </div>
                                                <div>
                                                    <a href="{{ route('invoice.download', $invoice->id) }}" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                                        Receipt
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
