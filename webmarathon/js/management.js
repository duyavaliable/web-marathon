//
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('edit-table'); // Đảm bảo ID bảng đúng

    table.addEventListener('click', function(e) {
        if(e.target && e.target.classList.contains('entry-no')) {
            const td = e.target;
            const originalEntryNo = td.innerText.trim();
            
            // Kiểm tra nếu đã đang chỉnh sửa thì không làm gì
            if (td.querySelector('input')) return;
            
            // Tạo trường nhập liệu
            const input = document.createElement('input');
            input.type = 'text';
            input.value = originalEntryNo;
            input.className = 'edit-entry-no';
            td.innerHTML = '';
            td.appendChild(input);
            input.focus();

            // Xử lý khi rời khỏi trường nhập liệu
            input.addEventListener('blur', function() {
                const newEntryNo = this.value.trim();
                if(newEntryNo && newEntryNo !== originalEntryNo) {
                    // Tao form an đe gui du lieu cap nhat
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'management.php';// submit de gui request
                    
                    const originalInput = document.createElement('input');
                    originalInput.type = 'hidden';
                    originalInput.name = 'original_entry_no';
                    originalInput.value = originalEntryNo;
                    form.appendChild(originalInput);
                    
                    const newInput = document.createElement('input');
                    newInput.type = 'hidden';
                    newInput.name = 'new_entry_no';
                    newInput.value = newEntryNo;
                    form.appendChild(newInput);
                    
                    const updateButton = document.createElement('button');
                    updateButton.type = 'submit';
                    updateButton.name = 'update';
                    form.appendChild(updateButton);
                    
                    document.body.appendChild(form);
                    form.submit();
                } else {
                    td.innerText = originalEntryNo;
                }
            });

            // Xử lý khi nhấn phím Enter
            input.addEventListener('keypress', function(e) {
                if(e.key === 'Enter') {
                    input.blur();
                }
            });
        }
    });
});