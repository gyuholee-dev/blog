console.log('SCRIPT LOADED');

const Win = window;
Win.addEvent = window.addEventListener;
Win.removeEvent = window.removeEventListener;

const Doc = document;
Doc.addEvent = document.addEventListener;
Doc.removeEvent = document.removeEventListener;
Doc.getId = document.getElementById;
Doc.getQuery = document.querySelector;
