<script>
function exportTableToCSV(filename, tableSelector = 'table.acc-table') {
    let csv = [];
    let rows = document.querySelectorAll(tableSelector + " tr");
    
    for (let i = 0; i < rows.length; i++) {
        let row = [], cols = rows[i].querySelectorAll("td, th");
        
        // Skip rows that are hidden
        if (window.getComputedStyle(rows[i]).display === "none") {
            continue;
        }
        
        for (let j = 0; j < cols.length; j++) {
            // Get inner text, remove newlines, escape double quotes
            let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, ' ').replace(/"/g, '""').trim();
            row.push('"' + data + '"');
        }
        csv.push(row.join(","));
    }

    let csvFile = new Blob([csv.join("\n")], {type: "text/csv;charset=utf-8;"});
    let downloadLink = document.createElement("a");
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
    setTimeout(function() {
        document.body.removeChild(downloadLink);
        window.URL.revokeObjectURL(downloadLink.href);
    }, 100);
}
</script>
