<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    /* =============================================
       Members - shared actions (delete / restore / deceased)
       Buttons use: data-action="delete|purge|restore|deceased" data-id data-name
    ============================================= */
    const MEMBERS_URL = '{{ url('members') }}';
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
    const swalTheme = { background: 'var(--bg-card)', color: 'var(--text-main)' };

    // i18n helper (named tr so it never overrides window.t)
    function tr(key, fallback) {
        if (typeof window.__t === 'function') return window.__t(key, fallback);
        if (typeof window.t === 'function') return window.t(key, fallback);
        return fallback || key;
    }

    function esc(str) {
        const d = document.createElement('div');
        d.textContent = str || '';
        return d.innerHTML;
    }

    function showLoading(title) {
        Swal.fire({
            ...swalTheme,
            title: title,
            html: '<div class="loading-spinner"></div><p class="mt-2">' + tr('please_wait', 'Please wait') + '</p>',
            showConfirmButton: false,
            allowOutsideClick: false
        });
    }

    function confirmThen(options, onConfirm) {
        Swal.fire({
            ...swalTheme,
            showCancelButton: true,
            cancelButtonColor: '#6B7499',
            cancelButtonText: tr('cancel', 'Cancel'),
            ...options
        }).then(function (result) {
            if (result.isConfirmed) onConfirm(result);
        });
    }

    function putJson(url, body, successTitle) {
        showLoading(tr('processing', 'Processing...'));
        fetch(url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: body ? JSON.stringify(body) : undefined
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (!data.success) throw new Error(data.message || 'Something went wrong');
            return Swal.fire({
                ...swalTheme,
                icon: 'success',
                title: successTitle,
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            });
        })
        .then(function () { window.location.reload(); })
        .catch(function (err) {
            Swal.fire({
                ...swalTheme,
                icon: 'error',
                title: tr('error', 'Error!'),
                text: err.message,
                confirmButtonColor: '#EF4444'
            });
        });
    }

    function submitForm(formId) {
        showLoading(tr('deleting', 'Deleting...'));
        document.getElementById(formId).submit();
    }

    /* ---------- DELETE (active member) ---------- */
    function confirmDelete(id, name) {
        confirmThen({
            title: tr('delete_member', 'Delete Member?'),
            html: tr('delete_member_confirm', 'Are you sure you want to permanently delete <strong>{memberName}</strong>?<br><small>This action cannot be undone.</small>').replace('{memberName}', esc(name)),
            icon: 'warning',
            confirmButtonColor: '#EF4444',
            confirmButtonText: tr('yes_delete', 'Yes, delete!')
        }, function () { submitForm('delete-form-' + id); });
    }

    /* ---------- DELETE (deceased member, permanent) ---------- */
    function confirmDeletePermanent(id, name) {
        confirmThen({
            title: tr('permanently_delete', 'Permanently Delete?'),
            html: tr('permanently_delete_confirm', 'Are you sure you want to permanently delete <strong>{memberName}</strong>?<br><small>All records will be lost forever.</small>').replace('{memberName}', esc(name)),
            icon: 'error',
            confirmButtonColor: '#EF4444',
            confirmButtonText: tr('yes_delete', 'Yes, delete!')
        }, function () { submitForm('delete-deceased-form-' + id); });
    }

    /* ---------- RESTORE ---------- */
    function confirmRestore(id, name) {
        confirmThen({
            title: tr('restore_member', 'Restore Member?'),
            html: tr('restore_member_confirm', 'Are you sure you want to restore <strong>{memberName}</strong> to active members?').replace('{memberName}', esc(name)),
            icon: 'question',
            confirmButtonColor: '#0BA5C0',
            confirmButtonText: tr('yes_restore', 'Yes, restore!')
        }, function () {
            putJson(MEMBERS_URL + '/' + id + '/restore', null, tr('restored', 'Restored!'));
        });
    }

    /* ---------- MARK AS DECEASED ---------- */
    function openDeceasedModal(id, name) {
        confirmThen({
            title: tr('mark_as_deceased', 'Mark as Deceased'),
            html:
                '<div style="text-align:left;">' +
                    '<p>' + tr('mark_deceased_confirm', 'Mark <strong>{memberName}</strong> as deceased?').replace('{memberName}', esc(name)) + '</p>' +
                    '<label class="form-label" for="date_deceased_input">' + tr('date_of_death', 'Date of Death:') + '</label>' +
                    '<input type="date" id="date_deceased_input" class="form-control" max="' + new Date().toISOString().split('T')[0] + '" required>' +
                    '<small class="text-muted d-block mt-2">' + tr('deceased_move_note', 'This member will be moved to the Deceased Members section.') + '</small>' +
                '</div>',
            icon: 'info',
            confirmButtonColor: '#6B7499',
            confirmButtonText: tr('mark_deceased', 'Mark as Deceased'),
            preConfirm: function () {
                const date = document.getElementById('date_deceased_input').value;
                if (!date) {
                    Swal.showValidationMessage(tr('select_death_date', 'Please select the date of death'));
                    return false;
                }
                return { date_deceased: date };
            }
        }, function (result) {
            putJson(MEMBERS_URL + '/' + id + '/deceased', result.value, tr('marked_deceased', 'Marked as Deceased'));
        });
    }

    /* ---------- one click handler for every action button ---------- */
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-action]');
        if (!btn) return;
        const actions = {
            delete: confirmDelete,
            purge: confirmDeletePermanent,
            restore: confirmRestore,
            deceased: openDeceasedModal
        };
        const fn = actions[btn.dataset.action];
        if (fn) fn(btn.dataset.id, btn.dataset.name);
    });

    window.addEventListener('localeChanged', function () {
        if (typeof window.applyTranslations === 'function') window.applyTranslations();
    });
</script>