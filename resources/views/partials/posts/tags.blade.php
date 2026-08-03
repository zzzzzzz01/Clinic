@include('partials.modals.create-modals.tags')

<!-- TAGS WIDGET -->
<div class="sidebar-widget">
    <h4 class="sidebar-widget-title">
        @lang('words.tags') 
    </h4>
    <div class="tag-cloud">
        @forelse($tags as $tag)
            <a href="{{ route('tag.posts', $tag->slug) }}" class="tag-item">{{ $tag->name }}</a>
        @empty
            <span class="text-muted">@lang('words.no_tags')</span>
        @endforelse
        <a href="#" class="tag-add-btn" onclick="openTagDialog('tagDialog')">
            <i class="fas fa-plus"></i>
        </a>
    </div>
</div>

<script>
    let tagScrollPosition = 0;

    function lockTagBodyScroll() {
        tagScrollPosition = window.pageYOffset || document.documentElement.scrollTop;

        document.body.style.position = 'fixed';
        document.body.style.top = `-${tagScrollPosition}px`;
        document.body.style.left = '0';
        document.body.style.right = '0';
        document.body.style.width = '100%';

        document.documentElement.classList.add('modal-open');
        document.body.classList.add('modal-open');
    }

    function unlockTagBodyScroll() {
        document.documentElement.classList.remove('modal-open');
        document.body.classList.remove('modal-open');

        document.body.style.position = '';
        document.body.style.top = '';
        document.body.style.left = '';
        document.body.style.right = '';
        document.body.style.width = '';

        window.scrollTo({
            top: tagScrollPosition,
            behavior: 'instant'
        });
    }

    function openTagDialog(dialogId) {
        const dialog = document.getElementById(dialogId);

        if (!dialog) return;

        lockTagBodyScroll();

        dialog.showModal();

        const form = dialog.querySelector('form');
        if (form) {
            form.reset();
        }
    }

    function closeTagDialog(dialogId) {
        const dialog = document.getElementById(dialogId);

        if (!dialog) return;

        dialog.close();
        unlockTagBodyScroll();
    }

    document.querySelectorAll('#tagDialog').forEach(dialog => {

        dialog.addEventListener('close', function () {
            unlockTagBodyScroll();
        });

        dialog.addEventListener('cancel', function () {
            unlockTagBodyScroll();
        });

    });
</script>
 