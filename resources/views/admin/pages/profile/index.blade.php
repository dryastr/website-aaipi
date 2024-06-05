<x-base-layout :title="$title">
    <x-slot name="headerFiles">
        @stack('headerFile')
    </x-slot>

    @include('admin.pages.profile.nav-link')
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h5 class="">{{$title}}</h5>
                    <div class="task-action">
                        @yield('action')
                    </div>
                </div>
                <div class="widget-content">
                    @yield('content')
                </div>
            </div>

        </div>
    </div>
    <x-slot name="footerFiles">
        @stack('footerFile')
    </x-slot>
</x-base-layout>
