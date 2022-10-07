# Jobs from Recruitee

Contributors: nightillusions
Donate link: https://jordin.eu
Tags: recruitee, jobs, career, careers page, job lists, job listing, job board, shortcode, page, pages, posts, work
Requires at least: 5.8
Tested up to: 6.0.2
Stable tag: 1.3
Requires PHP: 7.4
License: GPLv3 or later License URI: https://www.gnu.org/licenses/gpl-3.0.txt

Easily display published jobs from Recruitee anywhere with shortcode.

## Description

It's never been easier to display your public Recruitee jobs on your WordPress site. With a simple shortcode that you can use in the editor, in widgets or even in your template files, you can embed your job offers anywhere.

**Example:**

`[recruitee-jobs company="yourcompany"]`

## Features

- **Department filtering:** Show only jobs from a specific department

  `department="UX"`

- **Tag filtering:** show only jobs with a specific tag

  `tags="Master,Thesis"`

- **Custom Links:** Set the URL to which the jobs link to

  `url="https://example.com/jobs"`

- Language selection:\*\* Choose the language of the displayed texts
  `language="de"`
- **Text Preview Length:** Choose if and how long the job description should be displayed

  `preview_size="55"`

- **Custom Suffix Text:** Determine what text should be displayed after the shortened description if it was longer than the preview length

  `more="..."`

- **Raw or HTML:** You can choose whether to use the HTML text of the job ad or a simple text excerpt without HTML

  `raw="0"`

- **Track where your candidates come from:** You can simply add a source to track where the candidates applying for your jobs come from

  `source="yourcompany.tld"`

- **Display location:** Display the job location before the description

  `show_location="1"`

- **Display tags:** Display the job tags before the description

  `show_tags="1"`

## Frequently Asked Questions

### How to use the shortcode?

First you have to replace the company tag value by your Recruitee Careers Site subdomain. The scheme looks like this: `https://`**`yourcompany`**`.recruitee.com`
Where **`yourcompany`** is your Recruitee subdomain. You can usually find this in your Recruitee administration interface.

In the visual editor you can simply add a new Shortcode block by clicking on the [+] icon.
Then search for `Shortcode` and click on it. Next you add your own recruitee shortcode in the input field
(e.g.: `[recruitee-jobs company="`**`yourcompany`**`"]` ).
That´s it! :)

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
2. Easily display all public jobs from your Recruitee

## Changelog

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

### Welcome
