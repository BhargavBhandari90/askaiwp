# AskaiWP

[![Lint JS](https://github.com/BhargavBhandari90/askaiwp/actions/workflows/lint-js.yml/badge.svg)](https://github.com/BhargavBhandari90/askaiwp/actions/workflows/lint-js.yml)
[![WPCS](https://github.com/BhargavBhandari90/askaiwp/actions/workflows/wpcs.yml/badge.svg)](https://github.com/BhargavBhandari90/askaiwp/actions/workflows/wpcs.yml)

**Contributors:** [bhargavbhandari90](https://profiles.wordpress.org/bhargavbhandari90/)  
**Donate link:** [https://www.paypal.me/BnB90/20](https://www.paypal.me/BnB90/20)  
**Tags:** ai, chat, gemini, askai, chatbot  
**Requires at least:** 6.7  
**Tested up to:** 6.8  
**Stable tag:** 1.0.0  
**Requires PHP:** 7.4  
**License:** GPLv2 or later  
**License URI:** [https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html)

Add an AI-powered chat box to any single page on your WordPress site. AskaiWP analyzes the content of the current page and provides intelligent, context-aware answers directly to your visitors.

## Description

**AskaiWP** is an AI chat box designed to enhance user interaction on your WordPress pages.

* Uses Gemini AI to understand and analyze your current page content
* Instantly answers visitor questions based on that page's information
* Keeps users engaged without them needing to scroll or search manually

Perfect for documentation pages, product detail pages, service descriptions, or any content where visitors might need quick, personalized answers.

## Installation

1. Upload the plugin folder to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the **Plugins** screen in WordPress.
3. The AI chat box will automatically appear on single pages. Configure settings under **Settings → AskaiWP**.

## External Services

This plugin connects to Google's Generative AI API (Gemini) to process and respond to user prompts and to summarize webpage content.

When you use the chat feature, the plugin sends:
- Your entered question or prompt text.
- Page content from the page you visit ( NOT from database ).

This data is sent to:
Google Generative AI API (Gemini)  
Base URLs:  
- https://generativelanguage.googleapis.com/  
- https://aiplatform.googleapis.com/  
- https://vertexai.googleapis.com/  

The data is transmitted over HTTPS and used only to generate AI-powered responses. No personal identifying data is sent unless you explicitly include it in your prompt.

You must provide your own Gemini API key for the plugin to function. Without it, no data will be sent.

**Service provider:** Google LLC  
**Terms of Service:** https://ai.google.dev/terms  
**Privacy Policy:** https://policies.google.com/privacy

## Demo
Coming Soon...

## Prerequisites

* [Node/NPM](https://nodejs.org/en/download/)
* [NVM](https://github.com/nvm-sh/nvm)

## Development Setup

1. Go to the plugin’s root directory.
2. Run `npm install`.
3. To watch for changes, run `npm start`.

## Development

To create a publish-ready build, run:

```
npm run build
```

To format code, run:

```
npm run format
```

## Found a Bug?

Please report issues here:
[https://github.com/BhargavBhandari90/askaiwp/issues](https://github.com/BhargavBhandari90/askaiwp/issues)


## Changelog

### 1.0.0

* Initial release.
