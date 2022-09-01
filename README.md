# Jobs from Recruitee

Contributors: nightillusions
Donate link: https://jordin.eu
Tags: jobs, recruitee, shortcode
Requires at least: 5.8
Tested up to: 6.0.2
Stable tag: 1.0
Requires PHP: 7.4
License: GPLv3 or later License URI: https://www.gnu.org/licenses/gpl-3.0.txt

Easily display published jobs from Recruitee anywhere with shortcode.

## Description

It's never been easier to display your public Recruitee jobs on your WordPress site. With a simple
shortcode `[recruitee-jobs company="yourcompany"]` that you can use in the editor, in widgets or even in your template
files, you can embed your job offers anywhere.

## Features

- `departments="UX"` Department filtering: Show only jobs from a specific department
- `tags="Master,Thesis"` Tag filtering: show only jobs with a specific tag
- `url="https://example.com/jobs"` Custom Links: Set the URL to which the jobs link to
- `language="de"` Language selection: Choose the language of the displayed texts
- `preview_size="55"` Text Preview Length: Choose if and how long the job description should be displayed
- `more="..."` Custom Suffix Text: Determine what text should be displayed after the shortened description if it was longer than the preview length
- `raw="0"` Raw or HTML: You can choose whether to use the HTML text of the job ad or a simple text excerpt without HTML
- `source="yourcompany.tld"` Track where your candidates come from: You can simply add a source to track where the candidates applying for your jobs come from

## Frequently Asked Questions

### How to use the shortcode?

In the visual editor you can simply add a new Shortcode block by clicking on the [+] icon.
Then search for `Shortcode` and click on it. Next you add your own recruitee shortcode like `[recruitee-jobs company="yourcompany"]`
in the input field. That´s it! :)

### How do I style the jobs?

Just override the css classes that are used in this plugin. Follow the CSS Cascade to find your best solution https://wattenberger.com/blog/css-cascade
For example you could change the background color of the box:
`.recruitee-jobs-container article.recruitee-job { background: #dcff8c; }`
Or the text color of the title:
`.recruitee-jobs-container a { color: #322d7e; }`

## Screenshots

1. Easily display all public jobs from your Recruitee

## Changelog

### 1.0

- Initial stable plugin verions. Warm greetings :)

## Upgrade Notice

### Welcome
