<?php
include('parts/nav-bottom.php');
?>

<div id="custom-cursor"></div>

<script>
    const cursor = document.getElementById('custom-cursor');
    document.addEventListener('mousemove', e => {
        cursor.style.left = e.pageX + 'px';
        cursor.style.top = e.pageY + 'px';
    });

    // on page load, position cursor in center of screen
    window.addEventListener('load', () => {
        cursor.style.left = window.innerWidth / 2 + 'px';
        cursor.style.top = window.innerHeight / 2 + 'px';
    });

    document.addEventListener('click', () => {
        cursor.classList.add('expand');
        setTimeout(() => {
            cursor.classList.remove('expand');
        }, 500);
    });

    document.addEventListener('mouseover', e => {
        /* if item has hoverable class or is li item or is a item */
        if (e.target.classList.contains('hoverable') || e.target.tagName === 'LI' || e.target.tagName === 'A') {
            cursor.classList.add('hover');
        }
    });

    document.addEventListener('mouseout', e => {
        /* if item has hoverable class or is li item or is a item */
        if (e.target.classList.contains('hoverable') || e.target.tagName === 'LI' || e.target.tagName === 'A') {
            cursor.classList.remove('hover');
        }
    });

    // when page is loaded and ready, fade in cursor
    window.addEventListener('load', () => {
        cursor.classList.add('visible');
    });

    // when page is loaded and ready, fade in #app
    window.addEventListener('load', () => {
        document.getElementById('app').classList.add('visible');
    });

</script>
</body>
</html>
