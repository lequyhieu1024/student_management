<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo p-2">
                <img width="40" src="/admin/img/logo.jpg" alt="Web Logo" class="img-fluid">
            </span>
            <span
                class="app-brand-text demo menu-text text-base fw-bolder ms-2 text-uppercase">{{ __('Student Manager') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard"> {{ __('Dashboard') }} </div>
            </a>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle no-warning">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="menu-icon  bx bx-layout">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
                <div data-i18n="Student"> {{ __('Student Manager') }} </div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('students.index') }}" class="menu-link">
                        <div data-i18n="Danh sách khách hàng">{{ __('Student List') }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('students.create') }}" class="menu-link">
                        <div data-i18n="Tạo khách hàng mới"> {{ __('Create Student') }} </div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle no-warning">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" stroke-width="1.5"
                    fill="currentColor" class="bi bi-buildings menu-icon  bx bx-layout" viewBox="0 0 16 16">
                    <path
                        d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022M6 8.694 1 10.36V15h5zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5z" />
                    <path
                        d="M2 11h1v1H2zm2 0h1v1H4zm-2 2h1v1H2zm2 0h1v1H4zm4-4h1v1H8zm2 0h1v1h-1zm-2 2h1v1H8zm2 0h1v1h-1zm2-2h1v1h-1zm0 2h1v1h-1zM8 7h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zM8 5h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zm0-2h1v1h-1z" />
                </svg>
                <div data-i18n="Department"> {{ __('Department Manager') }} </div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('departments.index') }}" class="menu-link">
                        <div data-i18n="Danh sách khách hàng">{{ __('Department List') }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('departments.create') }}" class="menu-link">
                        <div data-i18n="Tạo khách hàng mới"> {{ __('Create Department') }} </div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle no-warning">
                {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="menu-icon  bx bx-layout">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg> --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" stroke-width="1.5"
                    fill="currentColor" class="bi bi-card-list menu-icon  bx bx-layout" viewBox="0 0 16 16">
                    <path
                        d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z" />
                    <path
                        d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8m0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0M4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0" />
                </svg>
                <div data-i18n="Department"> {{ __('Subject Manager') }} </div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('subjects.index') }}" class="menu-link">
                        <div data-i18n="Danh sách khách hàng">{{ __('Subject List') }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('subjects.create') }}" class="menu-link">
                        <div data-i18n="Tạo khách hàng mới"> {{ __('Create Subject') }} </div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle no-warning">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" stroke-width="1.5"
                    fill="currentColor" class="menu-icon  bx bx-layout" viewBox="0 0 16 16">
                    <path
                        d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917zM8 8.46 1.758 5.965 8 3.052l6.242 2.913z" />
                    <path
                        d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466zm-.068 1.873.22-.748 3.496 1.311a.5.5 0 0 0 .352 0l3.496-1.311.22.748L8 12.46z" />
                </svg>
                <div data-i18n="Department"> {{ __('Transcript Manager') }} </div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('transcripts.index') }}" class="menu-link">
                        <div data-i18n="Danh sách khách hàng">{{ __('Transcript List') }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('transcripts.create') }}" class="menu-link">
                        <div data-i18n="Tạo khách hàng mới"> {{ __('Create Transcript') }} </div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
