<div class="well">
    <form action="/admin.php" method="post" class="form-inline" accept-charset="UTF-8">
        <div class="form-group">
            <label for="word">Add new word: </label>
            <input type="text" class="form-control" name="word" id="word" autofocus>
        </div>
        <input type="submit" class="btn btn-default" name="addWord" value="Add">
    </form>
</div>

<div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    Click any word to edit it.
</div>

<?php if(isset($message)): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?= $message ?>
    </div>
<?php endif; ?>

<table class="table table-striped">
    <tr>
        <th>Word</th>
        <th>Action</th>
    </tr>
    <?php foreach($words as $word): ?>
        <tr>
            <td>
                <a href="#" class="edit-word" data-type="text" data-pk="<?=$word->id?>" data-name="word" data-url="/admin.php" data-inputclass="form-control"><?=$word->word?></a>
            </td>
            <td>
                <form action="/admin.php" method="post" class="form-inline">
                    <input type="hidden" name="wordId" value="<?= $word->id ?>">
                    <button type="submit" class="btn btn-sm btn-danger" name="deleteWord"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<!--<script src="http://www.appelsiini.net/download/jquery.jeditable.mini.js"></script>-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap-editable/js/bootstrap-editable.min.js"></script>

<script>
   //turn to inline mode
   $.fn.editable.defaults.mode = 'inline';

   //support Bootstrap 3.3 glyphicons
   $.fn.editableform.buttons =
       '<button type="submit" class="btn btn-primary editable-submit">'+
       '<span class="glyphicon glyphicon-ok"></span>'+
       '</button>'+
       '<button type="button" class="btn btn-default editable-cancel">'+
       '<span class="glyphicon glyphicon-remove"></span>'+
       '</button>';

   $(document).ready(function() {
       $('.edit-word').editable();
   });
</script>
