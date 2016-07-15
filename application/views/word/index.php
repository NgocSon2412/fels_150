<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h2><?= lang('title_word'); ?></h2>
            <?php
                $message_flashdata = $this->session->flashdata('message_flashdata');

                if(isset($message_flashdata) && count($message_flashdata)) {

                    if($message_flashdata['type'] == 'successful') { ?>
                        <p style="color:#5cb85c;"><?= $message_flashdata['message'];?></p>
                    <?php } else if($message_flashdata['type'] == 'error') { ?>
                        <p style="color:red;"><?= $message_flashdata['message'];?></p>
                    <?php }
                }
            ?>
        </div>    
        <div class="row col-sm-6" style="margin-bottom: 20px;">
            <form method="post" action="" class="form-inline">
                <div class="col-sm-5">
                    <select id = "test" class="form-control" name="" onchange="search('word/search?')">
                        <option value="none"><?= lang('choose_catrgory')?></option>
                        <?php if (isset($list_categories) && count($list_categories)) {
                            foreach ($list_categories as $key => $value) { ?>
                                <option value="<?= $value['name']?>"><?= $value['name']?></option>        
                            <?php }              
                        } ?>
                    </select>
                </div>
                <div class="col-sm-7">
                    <input class="form-control" type="text" id="txt1" onkeyup="search('word/search?')">
                    <button type="submit" class="btn btn-default"><?= lang('search'); ?></button>
                </div>
            </form>
        </div>      
    </div>
    <div class="row col-sm-12"  id="index">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><div><label><input type="checkbox" id="checkAll"></label></div></th>
                        <th><?= lang('word'); ?></th>
                        <th><?= lang('answer'); ?></th>
                        <th><?= lang('category'); ?></th>
                        <th><?= lang('created_at'); ?></th>
                        <th><?= lang('updated_at'); ?></th>
                        <th>ID</th>
                        <th><?= lang('learn'); ?></th>
                        <th><?= lang('action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($list_word) && count($list_word)) {
                        foreach ($list_word as $key => $value) { ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class = "ch" name= "checkbox[]" value = "<?= $value['word_id']; ?>"/>
                                </td>
                                <td><a href="word/show/<?= $value['word_id']; ?>"><?= $value['content']; ?></a></td>
                                <td><?= $value['word_answer']['content']; ?></td>
                                <td><a href="category/show/<?= $value['category_id']; ?>"><?= $value['category_name']; ?></td>
                                <td><?= $value['created_at']; ?></td>
                                <td><?= $value['updated_at']; ?></td>
                                <td><?= $value['word_id']; ?></td>
                                <?php if($this->Learned_Word_Model->total(['word_id' => $value['word_id'],'user_id' => $this->authentication['id']]) == 0) { ?>
                                    <td><a href="learned_word/learn/<?= $value['word_id']; ?>?redirect= <?= current_url(); ?>"><?= lang('unlearn'); ?></a></td>
                                <?php } else { ?>
                                    <td><?= lang('learned'); ?></td>
                                <?php } ?>
                                <td>
                                    <a href= "word/edit/<?= $value['word_id'];?>"><?= lang('edit'); ?></a> | 
                                    <a class = "delete"  href= "word/delete/<?= $value['word_id']; ?>"><?= lang('delete'); ?></a>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo '<tr><td colspan="8">' . lang('no_data') . '</td></tr>';    
                    } ?>
                </tbody>
            </table>
        </div>
        <div class="col-sm-2" style="padding-left:0px;">
            <a href="word/add" class="btn btn-default"><?= lang('title_add_word'); ?></a>
        </div>
        <div class="col-sm-7">
            <input type="submit" class="btn btn-default delete" name="delete_more" value="<?= lang('delete'); ?>" />        
        </div>   
        <div class="col-sm-3">
            <?= isset($list_pagination) ? $list_pagination : ''; ?>    
        </div>        
    </div>
</div>
