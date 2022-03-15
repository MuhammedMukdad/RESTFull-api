## I did this project to apply which I learned in Laravel API.


#### What is this?
 This project allow users to sell or buy products form each other’s.
Each buyer has many transactions (purchases) and he can sell products if he want, and each seller has many products and he can purchase.
Each product has many categories and each categories has many products.
I provided a diagram (Purchase_Sale_System) to better understand the case study and the main endpoint.
#### The main packages I used:
•	Laravel-fractal: I use it to transform the column name in DB before I return the response and vice versa.
•	Laravel passport: I use it to implement user authentication.
#### Additional things:
I apply sending email for users accounts verification, sorting and filtering results based on query parameters, pagination of results, Implementing HATEOAS Hypermedia Controls, Implementing security layer using policies and gates of Laravel.
