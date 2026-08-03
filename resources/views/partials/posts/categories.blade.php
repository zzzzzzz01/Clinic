@include('partials.modals.create-modals.category')

<!-- SIDEBAR WIDGET -->
<div class="sidebar-widget">
    <h4 class="sidebar-widget-title">
        @lang('words.categories') 
    </h4>
    <ul class="category-list">
        @forelse($categories as $category)
        <li>
            <a href="{{ route('category.posts', $category->slug) }}">{{ $category->name }}</a>
            <span class="category-count"> {{ $category->posts_count ?? $category->posts()->count() }} </span>
        </li>
        @empty
        <li class="text-muted text-center py-2">@lang('words.no_categories')</li>
        @endforelse
        <li style="border-bottom: none; padding-bottom: 0;">
            <a href="#" style="color: #00BFFF; font-weight: 600;" onclick="openDialog('categoryDialog')">
                <i class="fas fa-plus"></i> @lang('words.add_new_category')
            </a>
            <span></span>
        </li>
    </ul>
</div>

<script>
    let scrollPosition = 0;

    function lockBodyScroll() {
        scrollPosition = window.pageYOffset || document.documentElement.scrollTop;

        document.body.style.position = 'fixed';
        document.body.style.top = `-${scrollPosition}px`;
        document.body.style.left = '0';
        document.body.style.right = '0';
        document.body.style.width = '100%';

        document.documentElement.classList.add('modal-open');
        document.body.classList.add('modal-open');
    }

    function unlockBodyScroll() {
        document.documentElement.classList.remove('modal-open');
        document.body.classList.remove('modal-open');

        document.body.style.position = '';
        document.body.style.top = '';
        document.body.style.left = '';
        document.body.style.right = '';
        document.body.style.width = '';

        window.scrollTo({
            top: scrollPosition,
            behavior: 'instant'
        });
    }

    function openDialog(dialogId) {
        const dialog = document.getElementById(dialogId);

        if (!dialog) return;

        lockBodyScroll();

        dialog.showModal();

        // Dialog ichidagi form bo'lsa reset qilamiz
        const form = dialog.querySelector('form');
        if (form) {
            form.reset();
        }
    }

    function closeDialog(dialogId) {
        const dialog = document.getElementById(dialogId);

        if (!dialog) return;

        dialog.close();
        unlockBodyScroll();
    }

    // Backdrop bosilganda yopish
    document.querySelectorAll('dialog').forEach(dialog => { 

        // ESC bosilganda
        dialog.addEventListener('close', function () {
            unlockBodyScroll();
        });

        dialog.addEventListener('cancel', function () {
            unlockBodyScroll();
        });

    });
</script>
