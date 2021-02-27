function printInvoice(url) {
    var printWindow = window.open( url, 'Print', 'left=200, top=200, width=750, height=600, toolbar=0, resizable=0');
    printWindow.addEventListener('load', function(){
        printWindow.print();
        // printWindow.close();
    }, true);
}
