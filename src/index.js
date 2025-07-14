/* global AskaiWP */

import { __ } from '@wordpress/i18n';
import { Button, Icon, TextareaControl } from '@wordpress/components';
import { useState, createRoot, useRef, useEffect } from '@wordpress/element';
import { closeSmall } from '@wordpress/icons';
import chatIcon from './ai-bubble.png';
import { GoogleGenAI } from '@google/genai';
import Loader from './components/loader';

function AskaiWPChat() {
	const [ isOpen, setIsOpen ] = useState( false );
	const [ input, setInput ] = useState( '' );
	const [ messages, setMessages ] = useState( [] );
	const [ loading, setLoading ] = useState( false );
	const [ displayedText, setDisplayedText ] = useState( '' );
	const greeting = __( 'How can I help you today?', 'askaiwp' );
	const aiName = AskaiWP.settings.ai_name || __( 'AI', 'askaiwp' );
	const geminiModel =
		AskaiWP.settings.gemini_model.replace( 'models/', '' ) ||
		'gemini-1.5-flash';
	const messagesEndRef = useRef( null );
	const ai = new GoogleGenAI( {
		apiKey: AskaiWP.settings.gemini_api_key || '',
	} );

	const aiPrompt =
		AskaiWP.settings.gemini_prompt ||
		`You are an AI assistant helping users understand the content of a webpage.

Instructions:
1. Answer the user's question based on the page content above
2. If the question is directly related to the page content, provide a detailed and helpful response
3. If the question is only partially related, acknowledge what you can answer from the page and suggest what might need additional context
4. If the question is completely unrelated to the page content, politely redirect them to ask questions about the current page
5. Use a friendly, conversational tone
6. If referencing specific parts of the page, mention them clearly
7. Anser from the above content only user ask question
8. If user greets, don't provide answer from the content, just greet them back

Please provide a clear, concise, and helpful response.`;

	// Close chat on Esc.
	useEffect( () => {
		const handleEsc = ( e ) => {
			if ( e.key === 'Escape' ) {
				setIsOpen( false );
			}
		};

		window.addEventListener( 'keydown', handleEsc );

		return () => window.removeEventListener( 'keydown', handleEsc );
	}, [] );

	useEffect( () => {
		if ( isOpen ) {
			let index = 0;
			setDisplayedText( '' ); // reset
			const interval = setInterval( () => {
				setDisplayedText( greeting.slice( 0, index + 1 ) );
				index++;
				if ( index === greeting.length ) {
					clearInterval( interval );
				}
			}, 50 );
			return () => clearInterval( interval );
		}
	}, [ isOpen, greeting ] );

	const sendMessage = async ( e ) => {
		if ( 'Enter' === e.key ) {
			e.preventDefault();
			handleSend();
		}
	};

	const handleSend = async () => {
		if ( ! input.trim() ) {
			return;
		}

		const userMessage = { sender: 'user', text: input };
		const postContent =
			document.querySelector( 'article.entry' ).textContent || '';
		const postTitle =
			document.querySelector( 'h1.entry-title' ).textContent || '';
		const pageDetails = {
			title: postTitle,
			content: postContent,
		};
		setMessages( ( prev ) => [ ...prev, userMessage ] );
		setInput( '' );
		setLoading( true );

		const prompt =
			aiPrompt +
			` Following is the page information:
Page Title: ${ pageDetails.title }

Page Content:
${ pageDetails.content }

User Question: ${ input }`;

		try {
			const response = await ai.models.generateContent( {
				model: geminiModel,
				contents: prompt,
			} );

			const aiText =
				response.text || 'Sorry, I could not generate a response.';

			setMessages( ( prev ) => [
				...prev,
				{ sender: 'ai', text: aiText },
			] );
		} catch ( error ) {
			let errorMsg = __(
				'AI is not available at the moment. Please try again later!',
				'askaiwp'
			);
			if ( error?.code === 429 ) {
				errorMsg = __(
					'You are sending too many requests. Please wait a moment and try again.',
					'askaiwp'
				);
			}
			setMessages( ( prev ) => [
				...prev,
				{ sender: 'ai', text: errorMsg },
			] );
		}

		setLoading( false );
	};

	useEffect( () => {
		if ( messagesEndRef.current ) {
			messagesEndRef.current.scrollIntoView( { behavior: 'smooth' } );
		}
	}, [ messages, loading ] );

	return (
		<>
			<div className={ `askaiwp-chat-box ${ isOpen ? 'open' : '' }` }>
				<div className="askaiwp-header">
					{ aiName }
					<Button
						onClick={ () => setIsOpen( false ) }
						variant="tertiary"
						icon={ closeSmall }
						className="askaiwp-close-btn"
					></Button>
				</div>
				<div className="askaiwp-body">
					{ messages.length === 0 && (
						<div className="askaiwp-greeting">
							{ displayedText }
						</div>
					) }
					<div className="askaiwp-messages">
						{ messages.map( ( msg, index ) => (
							<div
								key={ index }
								className={ `askaiwp-message askaiwp-message-${
									msg.sender === 'user' ? 'user' : 'ai'
								}` }
							>
								<div className="askaiwp-bubble">
									<strong>
										{ msg.sender === 'user'
											? 'You'
											: aiName }
										:{ ' ' }
									</strong>
									<div
										className="askaiwp-text"
										dangerouslySetInnerHTML={ {
											__html: msg.text,
										} }
									/>
								</div>
							</div>
						) ) }
						<div ref={ messagesEndRef }></div>
					</div>
					{ loading && <Loader /> }
					<TextareaControl
						__nextHasNoMarginBottom
						value={ input }
						onChange={ ( value ) => setInput( value ) }
						placeholder={ __(
							'Type your question here…',
							'askaiwp'
						) }
						help={ __( 'Press ENTER to Send', 'askaiwp' ) }
						className="askaiwp-input"
						onKeyDown={ sendMessage }
					/>
					<Button
						onClick={ handleSend }
						variant="tertiary"
						label="Send"
						className="askaiwp-send-btn"
					>
						Send
					</Button>
				</div>
			</div>

			{ ! isOpen && (
				<Button
					className="askaiwp-floating-icon"
					onClick={ () => setIsOpen( true ) }
				>
					<Icon
						icon={ ( { size } ) => (
							<img
								width={ size }
								height={ size }
								src={ chatIcon }
								alt="AskaiWP"
							/>
						) }
					/>
				</Button>
			) }
		</>
	);
}

const domNode = createRoot( document.getElementById( 'askaiwp-root' ) );

window.addEventListener(
	'load',
	function () {
		domNode.render( <AskaiWPChat /> );
	},
	false
);
