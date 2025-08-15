=== AskaiWP ===
Contributors:      bhargavbhandari90, biliplugins
Donate link:       https://www.paypal.me/BnB90/20
Tags:              ai, chat, gemini, askai, chatbot
Requires at least: 6.6
Tested up to:      6.8
Stable tag:        1.0.0
License:           GPL-2.0-or-later
Requires PHP:      7.4
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

Summarize, explain, and chat — directly on your WordPress site.

== Description ==

AskaiWP adds an AI-powered chat assistant to the bottom-right corner of your WordPress site. Visitors can interact with Gemini AI to:

- Get a short summary of the current page.
- Ask questions about the content.
- Get explanations, highlights, and follow-up answers.

Perfect for blogs, tutorials, and knowledge bases — AskaiWP brings AI to the front of your content.

== Features ==

* Floating AI chat icon.
* Slide-out chat panel with full-screen height.
* Gemini AI-powered page summarization.
* Automatically reads page content.
* Responsive and mobile-friendly UI.
* Escape key and outside click support to close chat.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/askaiwp` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Add your Gemini API key in the plugin settings.
4. You're all set! Click the floating icon on any page to start chatting.

== Screenshots ==

1. Chat Bubble.
2. Opened AI chat window with summary interaction.
3. Chatbot Setting.

== External Services ==

This plugin connects to Google's Generative AI API (Gemini) to process and respond to user prompts and to summarize webpage content.

When you use the chat feature, the plugin sends:
- Your entered question or prompt text.
- (Optional) Page content or excerpts you choose to summarize.

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

== GitHub Repo ==
[https://github.com/BhargavBhandari90/askaiwp](https://github.com/BhargavBhandari90/askaiwp)

== Changelog ==

= 1.0.0 =
* Initial Release.
