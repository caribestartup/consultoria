<!-- @Page Loader -->
<!-- =================================================== -->
<div id='loader'>
    <img src="{{ asset('/images/Logo-GIF.gif') }}" height="64px" width="64px" class="pos-a"
         style="top: calc(50vh - 36px); left: calc(50vw - 32px)"/>
</div>

<script>
    window.addEventListener('load', () => {
        const loader = document.getElementById('loader');
        setTimeout(() => {
            loader.classList.add('fadeOut');
        }, 300);
    });
</script>
