/*
 * Copyright (c) 2017  |  Netraa, LLC
 * netraa414@gmail.com  |  https://netraa.us
 *
 * Andrew Gunn  |  Owner
 * https://andrewgunn.org
 */

/**
 * Created by andy on 2/25/17.
 */
var WPAPI = require('wpapi');
var WPAPI = require('wpapi');
var wp = new WPAPI({ endpoint:'http://src.wordpress-develop.dev/wp-json' });
var apiPromise = WPAPI.discover(host.url);

var wordpress = require("wordpress");
var client = wordpress.createClient({
  url:"my-site.com",
  username:"admin",
  password:"secret"
});
var apiPromise = WPAPI.discover('http://my-site.com').then(function (site) {
  return site.auth({
    username:'admin',
    password:'always use secure passwords'
  });
});
apiPromise.then(function (site) {
  // site is now configured to use authentication
});

client.getPosts(function (error, posts) {
  console.log("Found " + posts.length + " posts!");
});
// Callbacks
wp.posts().get(function (err, data) {
  if (err) {
    // handle err
  }
  // do something with the returned posts
});
wp.posts().create({
  // "title" and "content" are the only required properties
  title:'Your Post Title',
  content:'Your post content',
  // Post will be created as a draft by default if a specific "status"
  // is not specified
  status:'publish'
}).then(function (response) {
  // "response" will hold all properties of your newly-created post,
  // including the unique `id` the post was assigned on creation
  console.log(response.id);
});

wp.media()
// Specify a path to the file you want to upload, or a Buffer
  .file('/path/to/the/image.jpg')
  .create({
    title:'My awesome image',
    alt_text:'an image of something awesome',
    caption:'This is the caption text',
    description:'More explanatory information'
  })
  .then(function (response) {
    // Your media is now uploaded: let's associate it with a post
    var newImageId = response.id;
    return wp.media().id(newImageId).update({
      post:associatedPostId
    });
  })
  .then(function (response) {
    console.log('Media ID #' + response.id);
    console.log('is now associated with Post ID #' + response.post);
  });

// .id() must be used to specify the post we are updating
wp.posts().id(2501).update({
  // Update the title
  title:'A Better Title',
  // Set the post live (assuming it was "draft" before)
  status:'publish'
}).then(function (response) {
  console.log(response);
});

// Promises
wp.posts().then(function (data) {
  // do something with the returned posts
}).catch(function (err) {
  // handle error
});
site.handler().param('genre', genreTermId);

site.books = site.registerRoute('myplugin/v1', 'books/(?P<id>)', {
  params:['genre']
});
// yields
site.books().genre([genreId1, genreId2]);


process.env.NODE_TLS_REJECT_UNAUTHORIZED = "0";
