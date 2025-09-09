<div class="container">
    <h3>Bookshop Settings</h3>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?= form_open(base_url(route_to('admin.settings.save'))) ?>

    <div id="settings-wrapper">
        <?php foreach($settings as $setting): ?>
            <div class="form-row align-items-center setting-row mb-2">
                <div class="col">
                    <input type="text" name="setting_key[]" value="<?= esc($setting['setting_key']) ?>" placeholder="Key" class="form-control setting-key" required>
                </div>
                <div class="col">
                    <input type="text" name="setting_value[]" value="<?= esc($setting['setting_value']) ?>" placeholder="Value" class="form-control">
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
                </div>
                <div class="w-100 text-danger key-error" style="display:none;">Duplicate key!</div>
            </div>
        <?php endforeach; ?>
    </div>

    <button type="button" class="btn btn-secondary btn-sm mb-3" id="add-setting">Add Setting</button>
    <div>
        <?= form_submit('submit','Save Settings',['class'=>'btn btn-primary', 'id'=>'save-settings']) ?>
    </div>

    <?= form_close() ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('settings-wrapper');
    const addBtn = document.getElementById('add-setting');
    const saveBtn = document.getElementById('save-settings');

    function checkDuplicateKeys() {
        const keys = Array.from(wrapper.querySelectorAll('.setting-key')).map(input => input.value.trim().toLowerCase());
        const duplicates = {};
        let hasDuplicate = false;

        keys.forEach((key, i) => {
            if(key === '') return;
            if(duplicates[key]) {
                duplicates[key].push(i);
            } else {
                duplicates[key] = [i];
            }
        });

        wrapper.querySelectorAll('.setting-row').forEach((row, i) => {
            const keyInput = row.querySelector('.setting-key');
            const errorDiv = row.querySelector('.key-error');
            if(duplicates[keyInput.value.trim().toLowerCase()] && duplicates[keyInput.value.trim().toLowerCase()].length > 1) {
                errorDiv.style.display = 'block';
                hasDuplicate = true;
            } else {
                errorDiv.style.display = 'none';
            }
        });

        return hasDuplicate;
    }

    addBtn.addEventListener('click', function() {
        const div = document.createElement('div');
        div.className = 'form-row align-items-center setting-row mb-2';
        div.innerHTML = `
            <div class="col">
                <input type="text" name="setting_key[]" placeholder="Key" class="form-control setting-key" required>
            </div>
            <div class="col">
                <input type="text" name="setting_value[]" placeholder="Value" class="form-control">
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
            </div>
            <div class="w-100 text-danger key-error" style="display:none;">Duplicate key!</div>
        `;
        wrapper.appendChild(div);
    });

    wrapper.addEventListener('click', function(e) {
        if(e.target.classList.contains('remove-row')) {
            e.target.closest('.setting-row').remove();
        }
    });

    wrapper.addEventListener('input', function(e) {
        if(e.target.classList.contains('setting-key')) {
            checkDuplicateKeys();
        }
    });

    saveBtn.addEventListener('click', function(e) {
        if(checkDuplicateKeys()) {
            e.preventDefault();
            alert('Please fix duplicate keys before saving.');
        }
    });
});
</script>
