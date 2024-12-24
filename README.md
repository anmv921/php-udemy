# Transactions and receipts

## Description

This is a CRUD app for tracking expenses that implements the site described in the Udemy tutorial on the following page:

[Complete Modern PHP Developer Course | Udemy](https://www.udemy.com/share/109g543@XJzHJ0Aen-pd1mi_PNdjRcoViTL3U4BKx61Iim_9eh-4WyQMeOp3ePtKB6wjlgDLQQ==/ "Complete Modern PHP Developer Course | Udemy")

This site implements a custom framework simmilar to Laravel and follows a MVC, Model-View-Controller
logic.

The model layer connects to a MySQL database that saves the created transactions.

<!-- <img alt="ticket form 1" 
src="https://github.com/anmv921/rumos-dicionario-mvc/blob/main/readme_images/home.PNG" width="750px" />  -->

The homepage is a list of transactions, displaying the ammount, the description, the receipts and the date.

The actions column allows for the upload of files, the edition of the transaction info and the deletion of the items.
Clicking on the receipt icon we can display the file in the browser, or delete it.

Furthermore, the site implements an authorization and authentication system, so that the transactions are
only visible for specific users. A registration and login are therefore required and a guard system prevents
unauthorized operations.