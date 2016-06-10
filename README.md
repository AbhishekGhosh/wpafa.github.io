# WordPress - Application Framework using AngularJS (wp-afa)

![WordPress - Application Framework using AngularJS](http://hasanhalabi.github.io/wpafa.github.io/images/Logo.png)

## About the Plugin.

The main purpose of the plugin is to help developers create interactive business applications using WordPress and AngularJS. The plugin itself is not an application, it is just a component to standardize POST requests/responses between front-end AngularJS Page Templates and backend Model Layer built by the developers.

![WP-AFA   Communication Sequence](http://hasanhalabi.github.io/wpafa.github.io/images/wp-afa.jpg)
## The Story Behind The Plugin

WordPress is the most popular Blogging and Websites framework exists nowadays. It represents the core of the business model for many companies, developers, and designers out there. A lot of them added great features to it and made it more profitable and energetic.

Most of these additions and features comes in the domain of Blogs, Websites, eCommerce, and Portals. But what about dedicated web solutions for Small/Medium business? Such as CRM, Accounting, Contact Management, Internal Business Operations Workflow, and others. Could we utilize WordPress to build such applications?!

In fact, yes we could. I found many articles on the internet talking about this subject and the most notable one I found written by "Tom McFarlin" [@tommcfarlin](https://twitter.com/tommcfarlin) . He wrote a series of articles under the title "Using WordPress for Web Application Development" and you can find them on http://goo.gl/Gc4uWf. In these articles he talks about the difference between an "Application Framework" and "Application Foundation", and why we should deal with WordPress as application foundation.

Back in March 2015, our firm in Amman got a client looking to manage his business workflow. The budget was very tight, and I was the only developer. So I were looking to find a solution to complete the project in hand without going into building the software totally from scratch. At the end I managed to create the application using WordPress with the help of the wonderful plugin pods.io.

On November 2015, we got another client looking for custom Accounting/Financial System also with very limited budget. So again we used WordPress to do that. But this time we used a better infrastructure:

* We created a different plugin for each module (Clients, Vendors, Core Accounting, etc…) and created Pages Templates within the plugins as the system pages.
* We used AngularJS to build an interactive attractive front end pages.
* To server the AngularJS we created a WordPress page template which accept POST requests and return JSON data. This was core REST API of the application.
* For the reports we used plain HTML.
* For the widgets of the Dashboard we used AngularJS Templates.
* For the roles and privileges we made custom post types using pods.io plugin.
* The structure we used is not the best one exists, but it was suitable, scalable, and most importantly it finished the job.

When we built this framework, we were planning to use it for all the following web application we have. So we made the plugins tightly coupled with the theme. Especially that the theme is great and have a lot of nice touches for the user experience.

Now we are looking to create something reusable by other developers. This what made us create this plugin. It is very simple, direct to the point, and still in the early stages.

## [Examples](https://www.youtube.com/watch?v=FXYZP_qEVlM)

We made few applications using this framework, you can find the below sample videos for the application we built using WordPress:

* [YouTube Video](https://www.youtube.com/watch?v=FXYZP_qEVlM)

## Targets On The Current Phase

* Make sure the plugin is reusable and understandable by the developers.
* Make sure the plugin is secure and safe to use by developers.
* Increase the usage of WordPress for business application development.


## What We need in the current phase

Currently I'm the only developer for the project. You can find me on GitHub [@hasanhalabi](https://github.com/hasanhalabi/). It is just the start, and we need some help:

* Your review on the idea and structure.
* List of features to add to the plugin.
* List of Bugs.
* Any discussion will be a great help at the moment.

## Documentation

A complete documentation is going to be placed on the Project Wiki. The documentation is not ready at the moment. We hope we can write it very soon.

## Donations

As many out there, we are looking to pay bills and on the same time reduce the working hours so we could focus more on the project. So we do accept donations to help us adding new features and fix the bugs of the public plugins, but we don’t like to accept donations for free, so we will give you something back in return.

* If you donate less than **100$**, we will add your name in the donors list with a big thanks.
* If you donate **100$**, we will send you the source code for the framework we are using to build the business applications including:
  * The WordPress theme we are using with all of its components.
  * The plugins we built to facilitate all the features exists in the framework such as:
    * Users and Roles managements.
    * Dynamic Menu Building depending on the roles.
    * Dashboard building depending on the roles.
    * Reports listing.
    * Form validations.
    * REST API Page.
    * Custom login page.
    * Basic AngularJS controllers
    * And more…
  * Simple documentation on how to use the WordPress Themes and Plugins (framework) to create business applications.
  * A sample project of two pages (Contact List, and Donations Receipts) to demonstrate the usage of the framework.
* If you donate **300$**, we will do the following:
  * Send you the source code of the framework including all its features.
  * Answer 2 tickets to help you start using it.
* If you donate **500$**, we will do the following:
  * Send you the source code of the framework including all its features.
  * Answer 2 tickets to help you start using it.
  * Build any 2 pages on your request.
* If you donate **1000$**, we will do the following:
  * Send you the source code of the framework including all its features.
  * Answer 4 tickets to help you start using it.
  * Build any 4 pages on your request.
  * Open a live Skype call with you to explain the code line by line and go through all the details of the framework.

About the Framework license. I am the founder of the firm who created it. I have a partner, and we agreed to distribute under **MIT License**.

You can use [PayPal](https://www.paypal.com/myaccount/transfer/buy) to send us your donations. Just [click here](https://www.paypal.com/myaccount/transfer/buy)  and send the amount you want to hasanhalabi@gmail.com.

Many Thanks In Advance For All Of You.
