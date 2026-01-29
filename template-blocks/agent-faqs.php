<?php 
	$data = $block['data']; 
    
    $more_button_text = isset($data['more_button_text']) && !empty($data['more_button_text']) ? $data['more_button_text'] : 'Read More';
    $ppp = isset($data['posts_per_page']) && !empty($data['posts_per_page']) ? $data['posts_per_page'] : 10; 
?>
<section 
    <?php if (isset($data['section_id']) && $data['section_id']){ echo 'id="'.$data['section_id'].'"';} ?>
    class="agent-faqs-block <?php echo isset($block['className']) ? $block['className'] : ''; ?>"
>
	<div class="wrapper narrow">

		<?php if(isset($data['section_title']) && !empty($data['section_title'])) : ?>
			<h3 class="sectionTitle"><?php echo $data['section_title']; ?></h3>
		<?php endif; ?>

        <div id="<?php echo $block['id']; ?>">
            <ul class="list"></ul>
            <div class="moreWrap">
                <span class="bc-button" data-page="1"><?php echo $more_button_text; ?></span>
            </div>
        </div>
		
        <script>
            jQuery(document).ready(function($){
                const wrap = document.getElementById("<?php echo $block['id']; ?>")
                const list = wrap.querySelector('.list')
                const moreWrap = wrap.querySelector('.moreWrap')
                const moreButton = moreWrap.querySelector('.bc-button')

                // grab the case studies via ajax
                const getListItems = () => {

                    // localize click handler to this block
                    function handleToggleClick(e) {

                        // close all except this one first
                        const listItem = e.target.parentElement
                        const currentListItems = document.querySelectorAll("#<?php echo $block['id']; ?> .list li")
                        currentListItems.forEach(currentListItem => {
                            if (listItem !== currentListItem) {
                                currentListItem.classList.remove('active')
                            }
                        })

                        // toggle this one
                        if (listItem.classList.contains('active')) {
                            listItem.classList.remove('active')
                        } else {
                            listItem.classList.add('active')
                        }
                    }

                    // setup the payload
                    let data = {
                        action: 'get_list_items',
                        ppp: "<?php echo $ppp; ?>",
                        page: moreButton.getAttribute('data-page'),
                        post_type: 'agent-faq'
                    }
                    $.post("<?php echo admin_url('admin-ajax.php'); ?>", data, function(response){
                        
                        // parse the response
                        const responseObj = JSON.parse(response)

                        const parser = new DOMParser();
                        const doc = parser.parseFromString(responseObj.html, "text/html");

                        const listItems = doc.querySelectorAll('li')
                        listItems.forEach(listItem => {

                            // add event listeners 
                            const toggle = listItem.querySelector('.toggle')
                            toggle.addEventListener('click', handleToggleClick)
                            
                            // add to list
                            list.appendChild(listItem)
                        })

                        // maybe hide the more button
                        if (responseObj.maxNumPages >= responseObj.nextPage) {
                            moreButton.setAttribute('data-page', responseObj.nextPage)
                        } else {
                            moreWrap.style.display = 'none'
                        }
                    })
                }

                // on load
                getListItems()

                // more
                moreButton.addEventListener('click', function(){
                    getListItems()
                })
            })
        </script>
	</div>
</section>