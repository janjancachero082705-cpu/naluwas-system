// ============================================
// MARK AS READ
// ============================================
function markRead(id) {
    fetch(`/messages/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

// ============================================
// ARCHIVE
// ============================================
function archiveMessage(id) {
    if (!confirm('Archive this message?')) return;

    fetch(`/messages/${id}/archive`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        }
    })
    .then(() => window.location.href = MSG.indexUrl);
}

// ============================================
// DELETE
// ============================================
function deleteMessage(id) {
    if (!confirm('Delete this message permanently?')) return;

    fetch(`/messages/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        }
    })
    .then(() => window.location.href = MSG.indexUrl);
}
