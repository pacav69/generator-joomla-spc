# Debugging yeoman generators

## install node-inspector

https://github.com/node-inspector/node-inspector

then in a working directory type the following

	node-debug app/index.js

this will open up chrome and allow you to step through your code

You could place 'debugger statement in your code to force node to break at that point and wait for your inspection.