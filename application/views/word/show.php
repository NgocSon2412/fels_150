<?php if (isset($word_answer) && count($word_answer)) { ?>
    <p><?= $word['content'] .' : '. $word_answer['content']; ?></p>
<?php } else { ?>
    <p><?= $word['content']; ?>
<?php } ?>
