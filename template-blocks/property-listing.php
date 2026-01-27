<?php
    $disclaimer = get_field('disclaimer');
?>

<section class="block__propertyListing">
    <div class="wrapper narrow">
        <form class="searchForm" action="">
            <div class="searchIcon">
                <i class="fas fa-search"></i>
            </div>
            <input class="propertyAddressInput" type="text" name="address" placeholder="Search Property Address" />
            <button>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>
    </div>
    
    <?php if ($disclaimer) : ?>
        <div class="wrapper skinny">
            <div class="disclaimer">
                <?php echo $disclaimer; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="wrapper">
        <div class="propertyListWrap"></div>
        <div class="loadMoreWrap">
            <button class="loadMore">Load More</button>
        </div>
    </div>

    <script>
        const ppp = 12
        let keyword = ''
        let exclude = ''

        const getPropertyList = async (newSearch) => {

            if (newSearch) {
                exclude = ''
            }

            const data = new FormData()
            data.append('ppp', ppp)
            data.append('keyword', keyword)
            data.append('exclude', exclude)
            data.append('action', 'get_property_listing')
            const response = await (await fetch('/wp-admin/admin-ajax.php', {
                method: 'POST',
                body: data
            })).json()

            exclude = response.exclude

            // append response and maybe reset if keyword search
            const propertyListWrap = document.querySelector('.propertyListWrap')
            if (newSearch) {
                propertyListWrap.innerHTML = response.html
            } else {
                propertyListWrap.innerHTML += response.html
            }

            // show/hide if there are more
            const loadMoreWrap = document.querySelector('.loadMoreWrap')
            if (response.loadMore) {
                loadMoreWrap.classList.add('active')
            } else {
                loadMoreWrap.classList.remove('active')
            }

            // revert the load more button state
            const loadMoreButton = document.querySelector('.loadMore')
            loadMoreButton.classList.remove('active')
            loadMoreButton.innerHTML = 'Load More'
        }

        const searchForm = document.querySelector('.searchForm')
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault()
            keyword = document.querySelector('.propertyAddressInput').value
            getPropertyList(true)
        })

        const loadMoreButton = document.querySelector('.loadMore')
        loadMoreButton.addEventListener('click', function() {

            // maybe do grab more
            if (!loadMoreButton.classList.contains('active')) {
                loadMoreButton.classList.add('active')
                loadMoreButton.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i>'
                getPropertyList(false)
            }
        })

        // on load
        getPropertyList(true)
    </script>
</section>