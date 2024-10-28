
        <div class="dropdown d-inline-block user-dropdown">
            <button
                type="button"
                class="btn header-item waves-effect"
                id="page-header-user-dropdown"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >
                @if(app()->getLocale() == 'en')
                <span>ENG</span>
                @elseif(app()->getLocale() == 'fa')
                <span>FA</span>
                @else
                {{ strtoupper(app()->getLocale()) }}
                @endif
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="{{ route('lang.switch', ['lang' => 'en']) }}"
                   onclick="changeLangDir('en', 'ltr')">
                    <i class="ri-wallet-2-line align-middle me-1"></i> English
                </a>
                <a class="dropdown-item" href="{{ route('lang.switch', ['lang' => 'fa']) }}"
                   onclick="changeLangDir('fa', 'rtl')">
                    <i class="ri-wallet-2-line align-middle me-1"></i> فارسی
                </a>
            </div>
        </div>


    <script>
    function changeLangDir(lang, dir) {
        document.documentElement.lang = lang;
        document.documentElement.dir = dir;
        
        const mainTag = document.querySelector('main');
        if (lang === 'fa') {
            document.documentElement.setAttribute("lang", "fa");
            mainTag.classList.add('container');
            mainTag.classList.remove('main-content');
        } else {
            document.documentElement.setAttribute("lang", "en");
            mainTag.classList.add('main-content');
            mainTag.classList.remove('container');
        }

        // Store the direction in session storage to use it after reload
        sessionStorage.setItem('page_direction', dir);
    }

    // Apply stored direction on page load
    document.addEventListener('DOMContentLoaded', function() {
        const direction = sessionStorage.getItem('page_direction') || 'ltr';
        document.documentElement.dir = direction;

        const mainTag = document.querySelector('main');
        if (direction === 'rtl') {
            mainTag.classList.add('container');
            mainTag.classList.remove('main-content');
        } else {
            mainTag.classList.add('main-content');
            mainTag.classList.remove('container');
        }
    });
</script>

