export function getAvailableStock (product, item, items = [])  {
    if (!product.stock.length) {
        return false;
    }

    let purchasedQuantity = 0;
    let stock = Number(product.stock[0].totalStock);
    if(items.length) {
        let existingItem = items.find(x => x.product_id === item.product_id)
        if (existingItem) {
            purchasedQuantity = existingItem.quantity;
            stock = Number(stock) + Number(purchasedQuantity)
        }
    }

    return !(stock >= Number(item.quantity))
}

export function getTotalPrice(items) {
    let total = 0;
    items.forEach(item => {
        total = Number(total) + Number(item.total)
    })
    return total;
}
