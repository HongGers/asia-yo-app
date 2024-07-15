## AsiaYo 面試前測題目 - 鄭丞宏

### 資料庫測驗

#### 題目一

```
SELECT 
    b.id AS bnb_id,
    b.name AS bnb_name,
    SUM(o.amount) AS may_amount
FROM 
    orders o
JOIN 
    bnbs b ON o.bnb_id = b.id
WHERE 
    o.currency = 'TWD' AND
    o.created_at BETWEEN '2023-05-01' AND '2023-05-31'
GROUP BY 
    b.id, b.name
ORDER BY 
    may_amount DESC
LIMIT 10;
```

#### 題目二

可以使用 `mysqlslap` 等的工具來檢驗效能(網路上了解到的工具，本人無實際使用經驗)。可以透過建立 index 來加快查詢速度，以此題為例可建立 `orders(currency,amount)` 的index，因為此題的 query 主要是以 `currency` 和 `amount` 進行查詢及排序。

### API實作題

#### SOLID設計

- 將Model(此考題中未使用到)、Controller、Rule等依照功能區分成不同的class，讓一個class只負責單一個entity的邏輯，符合Single Responsibility Principle。Service的部分則是一個function只負責單一一個邏輯，不去做任何其他事情。

- 在 `PriceOverLimitRule` 中，用一個 private member 存金額上限，並可以在建構時指定，給予一個彈性，後續使用若需更改金額上限則無須回去改動這個class，符合Open-Closed Principle。

- 利用 `ValidationRule`、`FormRequest` 等類別，讓所有不同的rule及request都可以繼承，而其他介面也都依賴這些抽象的類別，符合Interface Segregation Principle。