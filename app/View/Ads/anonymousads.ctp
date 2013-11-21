<p class="text-center"><b>List of Ads to be linked to your account.</b></p>
<form action="<?php echo HTTP_ROOT.'ads/linkad'; ?>" method="post">
<?php echo $this->element('ads'); ?>
<p class="text-right" style="margin-right:150px;">
<button class="btn btn-large btn-primary" name="linked" type="submit">Link</button>
<button class="btn btn-large btn-primary" name="skipped" type="submit">Skip</button>
</p>
</form>