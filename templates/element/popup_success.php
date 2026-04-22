<script>
// Alert parent window with the new ID and Name
window.parent.postMessage({
    action: 'itemAdded',
    id: <?= json_encode($popupResult['id'] ?? '') ?>,
    name: <?= json_encode($popupResult['name'] ?? '') ?>
}, '*');
</script>
