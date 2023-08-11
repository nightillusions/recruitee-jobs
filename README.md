# Jobs from Recruitee

Contributors: nightillusions
Donate link: https://jordin.eu
Tags: career, careers page, job lists, job listing, job board, shortcode, page, pages, posts, work, recruitee
Requires at least: 5.8
Tested up to: 6.3.0
Stable tag: 1.4.1
Requires PHP: 7.4
License: GPLv3 or later License URI: https://www.gnu.org/licenses/gpl-3.0.txt

Easily display published jobs from Recruitee anywhere with shortcode.

## Description

It's never been easier to display your public Recruitee jobs on your WordPress site. With a simple shortcode that you can use in the editor, in widgets or even in your template files, you can embed your job offers anywhere.

**Example:**

`[recruitee-jobs company="yourcompany"]`

## Features

- **Display mode:** There are two modes available for displaying the jobs. _"tiles"_ displays the jobs as tiles, which is particularly suitable for displaying an excerpt of the job description. _"list"_ displays the jobs in a clear list, which is particularly suitable for ensuring a quick overview of all open jobs. _Default: "tiles"_

  `mode="list"`

- **Department filtering:** Show only jobs from a specific department. _Default: "" (empty)_

  `department="UX"`

- **Tag filtering:** show only jobs with a specific tag. _Default: "" (empty)_

  `tags="Master,Thesis"`

- **Custom Links:** Set the URL to which the jobs link to. _Default: "https://**yourcompany**.recruitee.com"_

  `url="https://example.com/jobs"`

- Language selection:\*\* Choose the language of the displayed texts. _Default: "" (empty)_
  `language="de"`
- **Text Preview Length:** Choose if and how long the job description should be displayed. _Default: "55"_

  `preview_size="35"`

- **Custom Suffix Text:** Determine what text should be displayed after the shortened description, if it was longer than the preview length. _Default: "..."_

  `more="[...]"`

- **Raw or HTML:** You can choose whether to use the HTML text of the job ad or a simple text excerpt without HTML. _Default: "0" (disabled)_

  `raw="1"`

- **Origin Tracking:** You can simply add a source to track where the candidates applying for your jobs come from. _Default: "" (empty)_

  `source="yourcompany.tld"`

- **Display location:** Display the job location before the description. _Default: "1" (enabled)_

  `show_location="0"`

- **Display tags:** Display the job tags before the description. _Default: "1" (enabled)_

  `show_tags="0"`

## Frequently Asked Questions

### How to use the shortcode?

First you have to replace the company tag value by your Recruitee Careers Site subdomain. The scheme looks like this: `https://`**`yourcompany`**`.recruitee.com`
Where **`yourcompany`** is your Recruitee subdomain. You can usually find this in your Recruitee administration interface.

In the visual editor you can simply add a new Shortcode block by clicking on the [+] icon.
Then search for `Shortcode` and click on it. Next you add your own recruitee shortcode in the input field
(e.g.: `[recruitee-jobs company="`**`yourcompany`**`"]` ).
That´s it! :)

### How to change default output?

Just as all shortcodes work, Jobs from Recruitee also offers the possibility to customize the default behavior of the output. For each of the features listed above, an example is given to change the corresponding behavior. Just add the parameter you want to change to your personal shortcode at the end. For example, if you want to disable the job location output, your shortcode would look like this:

    [recruitee-jobs company="yourcompany" show_location="0"]

### How do I style the jobs?

Just override the css classes that are used in this plugin. Follow the CSS Cascade to find your best solution https://wattenberger.com/blog/css-cascade
For example you could change the background color of the box:

    .recruitee-jobs-container article.recruitee-job {
        background: #dcff8c;
    }

Or the text color of the title:

    .recruitee-jobs-container a {
        color: #322d7e;
    }

## Screenshots

1. Easily place the shortcode anywhere on you site
2. Display all public jobs from your Recruitee in as tiles
3. Display all public jobs from your Recruitee in a list

## Changelog

### 1.4.0

- NEW Feature: Display Recruitee jobs as list
- Improved: The CSS classes are now easier to override.

### 1.3.1

- Fix: Raw mode has filtered out paragraphs.

### 1.3

- Feature: Optional display of the tags in the job listing
- Feature: Optional display of the location in the job listing
- Styling: Reduction of default spacing of heading and paragraphs

### 1.2

- Fix: Spaces in department filter caused problems with job retrieval.
- Fix: If no language is specified, the default text is now specified.

### 1.1

- Fix: Uncaught TypeError when there is a problem with Careers Site subdomain in the shortcode or no jobs listed.

### 1.0

- Initial stable plugin verions. Warm greetings :)

## Upgrade Notice

### 1.4.0

If you want the previous behavior (without location and tags) back, you should disable it in the shortcode as follows:

    [recruitee-jobs company="yourcompany" show_location="0" show_tags="0"]

### Welcome
