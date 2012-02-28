<?php if ($s5_scrolltotop  == "yes") { ?>
<script type="text/javascript">
function s5_scrollit() { new SmoothScroll({ duration: 800 }); }
function s5_scrollitload() {s5_scrollit();}
window.setTimeout(s5_scrollitload,400);
</script>
<a href="#s5_scrolltotop" class="s5_scrolltotop"></a>
<?php } ?>