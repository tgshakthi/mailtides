<div id="confirm_delete" class="confirm_delete">
    <div class="confirm_delete_content">
        <span class="confirm_delete_close">&times;</span>
        <form action="" id="confirm_delete_form" method="post" class="rename_popup">
            <input type="hidden" id="confirm_delete_path" name="confirm_delete_path" value="">
            <input type="hidden" id="confirm_delete_thumb_path" name="confirm_delete_thumb_path" value="">
            <input type="hidden" id="confirm_delete_folder" name="confirm_delete_folder" value="">
            <input type="hidden" id="confirm_delete_extention" name="confirm_delete_extention" value="">
            <p id="confirm_delete_content"></p>
            <input type="submit" name="confirm_delete_ok" id="confirm_delete_ok" value="OK" />
            <button class="confirm_delete_cancel">Cancel</button>
        </form>
    </div>
</div>

<div id="myfolder" class="myfolder">
    <div class="myfolder-content">
        <span class="close">&times;</span>
        <form action="" id="rename_form" method="post" class="rename_popup">
            <input type="hidden" id="folder_path" name="folder_path" value="">
            <input type="hidden" id="thumb_path" name="thumb_path" value="">
            <input type="hidden" id="old_folder_name" name="old_folder_name" value="">
            <input type="hidden" id="extension" name="extension" value="">
            <input type="text" id="new_folder_name" name="new_folder_name" required value="">
            <input type="submit" name="rename_submit" id="rename_submit" value="Submit" />
            <button class="rename_cancel">Cancel</button>
        </form>
    </div>
</div>

<div id="view_image" class="view_image">
    <div class="view_image_content">
        <span class="view_image_close">&times;</span>
        <img src="" id="original_image_view">
    </div>
</div>

<div id="create_folder" class="create_folder">
    <div class="myfolder-content">
        <span class="create_folder_close">&times;</span>
        <form action="" id="create_folder_form" method="post" class="rename_popup">
            <input type="hidden" id="create_folder_path" name="create_folder_path" value="">
            <input type="text" id="create_folder_name" name="create_folder_name" required value="">
            <input type="submit" name="create_folder_submit" id="create_folder_submit" value="Create" />
            <button class="create_folder_cancel">Cancel</button>
        </form>
    </div>
</div>