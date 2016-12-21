# EasyFooTables Content Plugin

A simple content plugin that processes tables preceded by `{footables}` and turns them into a [Footable](http://fooplugins.com/footable-demos/).

## Basic Usage Steps
  1. Install via the standard Joomla extension manager and enable it.
  2. Place a tag `{footables}` immediately before the table in your article.
  3. Add a the `footable` class to each table in the article you want Footable to work on.
  4. Configure each column of your Footable by adding `data-hide` attributes to determine when they are shown or hidden.

## data-hide Options

_This plugin uses [v2 of Footables](https://github.com/fooplugins/FooTable/tree/V2) at this point in time._

Footables V2 is uses `data` attributes on the column headings of your table. Specifically `data-hide` attributes are set with via two default breakpoints represented by the values `phone` and `tablet`. A third option `all` will hide the column all the time.

It's important to understand that Footables V2 doesn't actually look at the size of the browsers viewport (screen/window size), it looks at the size of the parent block (`div` etc). This means that applying the `data-hide="phone"` to a column is misleading, while you would expect it to only hide the column on a smartphone sized screen in fact it will hide the column if the parent block (e.g. a `div`) less than 480px wide.

Once you understand that it will make it clearer why the table is hiding/not hiding your columns.

## Notes
 - This plugin uses `v2` of FooTables as `v3` is in development.
 - This plugin will load jQuery from CDN if your site doesn't have it (see plugin parameters — you must turn it on, it's off by default).

 EasyFootables is a plugin to add 'FooTables' to HTML tables anywhere a Joomla Content plugin will work. So, in articles, custom html modules or components that support content plugins.

**For more details see [the FooTables demo](http://fooplugins.com/footable-demos/).**

## Credits
The FooTables jQuery plugin is created by the clever people from [FooPlugins.com](http://fooplugins.com) and does all the real work.
