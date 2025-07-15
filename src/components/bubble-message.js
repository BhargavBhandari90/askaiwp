import { __ } from '@wordpress/i18n';

export default function BubbleMessage() {
	return (
		<div className="askaiwp-bubble-message">
			{__('Need help? Ask me anything!', 'askaiwp')}
		</div>
	);
}
