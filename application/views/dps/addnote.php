<style type="text/css">
	
</style>
<form id="addnote-form" method="POST">
	<?php
		foreach ($note as $notes) {
			$added_note = $notes['note'];
		}
	?>
	<textarea name="note" id="note">dfgdfg</textarea>
	<input type="button" name="submit-note" id="submit-note" value="Post Note"/>
</form>
