## AsiaYo 面試前測題目 - 鄭丞宏

### API實作題

#### SOLID設計

- 將Model(此考題中未使用到)、Controller、Rule等依照功能區分成不同的class，讓一個class只負責單一個entity的邏輯，符合Single Responsibility Principle。Service的部分則是一個function只負責單一一個邏輯，不去做任何其他事情。

- 在 `PriceOverLimitRule` 中，用一個 private member 存金額上限，並可以在建構時指定，給予一個彈性，後續使用若需更改金額上限則無須回去改動這個class，符合Open-Closed Principle。

- 利用 `ValidationRule`、`FormRequest` 等類別，讓所有不同的rule及request都可以繼承，而其他介面也都依賴這些抽象的類別，符合Interface Segregation Principle。