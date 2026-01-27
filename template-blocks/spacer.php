<?php $data = $block['data']; ?>
<?php $height = isset($data['height']) ? 'height:'.$data['height'].';' : ''; ?>
<section 
    <?php if (isset($data['section_id']) && $data['section_id']){ echo 'id="'.$data['section_id'].'"';} ?>
    class="spacer-block" 
    style="<?php echo $height; ?>"
></section>