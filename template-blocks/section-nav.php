<?php $data = $block['data']; ?>

<?php if (isset($data['section_navigation']) && $data['section_navigation']) : ?>
    <section id="<?php echo $block['id']; ?>" class="section-navigation-block">
        <div class="wrapper">
            <ul class="sectionNav">
                <?php for ($i = 0; $i < $data['section_navigation']; $i++) : ?>
                    <li class="navItem">
                        <a href="#<?php echo $data["section_navigation_{$i}_section_id"]; ?>">
                            <?php echo $data["section_navigation_{$i}_section_title"]; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
        <script>
            const navLinks = document.querySelectorAll(`#<?php echo $block['id']; ?> .navItem a`)
            navLinks.forEach(navLink => {
                navLink.addEventListener('click', function(e){
                    e.preventDefault()
                    const target = document.querySelector(navLink.getAttribute('href'))
                    if (target) {
                        target.scrollIntoView({behavior: "smooth"})
                    }
                })
            })
        </script>
    </section>
<?php endif; ?>