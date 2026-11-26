<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>CRM AI | Code Sparrow</title>

    <style>
        :root {
            --brand: #0799aa;
            --brand-dark: #066d79;
            --brand-light: #e7f9fa;

            --page: #f5f7f7;
            --sidebar: rgba(245, 248, 248, 0.94);
            --white: #ffffff;
            --text: #1d1d1f;
            --secondary-text: #6e6e73;
            --tertiary-text: #929298;
            --border: rgba(30, 70, 76, 0.11);
            --hover: rgba(7, 153, 170, 0.065);
            --danger: #d94d61;
            --success: #20b985;

            --sidebar-width: 280px;
            --header-height: 72px;

            --shadow-small:
                0 5px 18px rgba(24, 56, 61, 0.055);

            --shadow-medium:
                0 15px 45px rgba(24, 56, 61, 0.09);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        body {
            color: var(--text);
            background: var(--page);
            font-family:
                -apple-system,
                BlinkMacSystemFont,
                "SF Pro Display",
                "SF Pro Text",
                "Segoe UI",
                sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        button,
        textarea {
            font: inherit;
        }

        button {
            border: 0;
            cursor: pointer;
        }

        [hidden] {
            display: none !important;
        }

        .app {
            display: grid;
            grid-template-columns:
                var(--sidebar-width) minmax(0, 1fr);
            width: 100vw;
            height: 100dvh;
            overflow: hidden;
            background:
                radial-gradient(
                    circle at 78% -10%,
                    rgba(7, 153, 170, 0.075),
                    transparent 33%
                ),
                var(--page);
        }

        /* Sidebar */

        .sidebar {
            position: relative;
            display: flex;
            min-height: 0;
            flex-direction: column;
            overflow: hidden;
            border-right: 1px solid var(--border);
            /* background: var(--sidebar); */
            background-color: white;
            backdrop-filter: blur(30px);
        }

        .sidebar::after {
            position: absolute;
            right: -130px;
            bottom: -140px;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background:
                radial-gradient(
                    circle,
                    rgba(7, 153, 170, 0.10),
                    transparent 70%
                );
            content: "";
            pointer-events: none;
        }

        .sidebar-scroll {
            position: relative;
            z-index: 2;
            min-height: 0;
            flex: 1;
            overflow-y: auto;
            padding: 22px 16px;
            scrollbar-width: thin;
            scrollbar-color:
                rgba(7, 153, 170, 0.30)
                transparent;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            border-radius: 20px;
            background: rgba(7, 153, 170, 0.30);
        }

        .brand {
            display: flex;
            align-items: center;
            min-height: 61px;
            margin-bottom: 17px;
            padding: 11px 13px;
            /* border: 1px solid rgba(255, 255, 255, 0.9); */
            border-radius: 17px;
            /* background: rgba(255, 255, 255, 0.68); */
            /* box-shadow: var(--shadow-small); */
        }

        .brand-logo {
            display: block;
            width: 205px;
            max-width: 100%;
            height: auto;
        }

        .brand-fallback {
            color: var(--brand-dark);
            font-size: 15px;
            font-weight: 750;
            letter-spacing: 0.02em;
        }

        .new-chat {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            min-height: 45px;
            margin-bottom: 27px;
            padding: 11px;
            border-radius: 13px;
            color: #ffffff;
            background:
                linear-gradient(
                    135deg,
                    #12aaba,
                    var(--brand-dark)
                );
            box-shadow:
                0 11px 27px rgba(7, 153, 170, 0.20);
            font-size: 12px;
            font-weight: 650;
            transition:
                transform 180ms ease,
                box-shadow 180ms ease;
        }

        .new-chat:hover {
            transform: translateY(-2px);
            box-shadow:
                0 15px 32px rgba(7, 153, 170, 0.27);
        }

        .section-label {
            margin: 0 10px 9px;
            color: var(--tertiary-text);
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.11em;
            text-transform: uppercase;
        }

        .prompt-list {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .prompt {
            display: flex;
            align-items: center;
            gap: 11px;
            width: 100%;
            min-height: 47px;
            padding: 8px 10px;
            border-radius: 12px;
            color: #46575b;
            background: transparent;
            text-align: left;
            transition:
                color 160ms ease,
                background 160ms ease,
                transform 160ms ease;
        }

        .prompt:hover {
            color: var(--brand-dark);
            background: var(--hover);
            transform: translateX(3px);
        }

        .prompt:disabled {
            cursor: wait;
            opacity: 0.45;
            transform: none;
        }

        .prompt-icon {
            display: grid;
            flex: 0 0 auto;
            place-items: center;
            width: 31px;
            height: 31px;
            border: 1px solid rgba(7, 153, 170, 0.09);
            border-radius: 10px;
            color: var(--brand-dark);
            background: var(--brand-light);
            font-size: 9px;
            font-weight: 700;
        }

        .prompt-text {
            font-size: 12px;
            font-weight: 550;
            line-height: 1.35;
        }

        .sidebar-footer {
            position: relative;
            z-index: 2;
            padding: 0 16px 16px;
        }

        .status-card {
            padding: 13px;
            border: 1px solid rgba(255, 255, 255, 0.88);
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.68);
            box-shadow: var(--shadow-small);
            backdrop-filter: blur(25px);
        }

        .status-title {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #365156;
            font-size: 10px;
            font-weight: 650;
        }

        .status-dot {
            position: relative;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--success);
            box-shadow:
                0 0 0 5px rgba(32, 185, 133, 0.10);
        }

        .status-dot::after {
            position: absolute;
            inset: -4px;
            border: 1px solid rgba(32, 185, 133, 0.35);
            border-radius: inherit;
            content: "";
            animation: statusPulse 2.2s infinite;
        }

        @keyframes statusPulse {
            0% {
                opacity: 0.9;
                transform: scale(0.7);
            }

            75%,
            100% {
                opacity: 0;
                transform: scale(1.8);
            }
        }

        .active-account {
            margin-top: 9px;
            color: var(--brand-dark);
            font-size: 9px;
            font-weight: 700;
        }

        .status-note {
            margin-top: 5px;
            color: var(--tertiary-text);
            font-size: 8px;
            line-height: 1.5;
        }

        /* Workspace */

        .workspace {
            display: flex;
            min-width: 0;
            min-height: 0;
            flex-direction: column;
            overflow: hidden;
        }

        .header {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex: 0 0 var(--header-height);
            padding: 10px 25px;
            border-bottom: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.78);
            backdrop-filter: blur(25px);
        }

        .header-left {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: 11px;
        }

        .mobile-menu {
            display: none;
            place-items: center;
            width: 38px;
            height: 38px;
            border: 1px solid var(--border);
            border-radius: 11px;
            color: var(--text);
            background: #ffffff;
        }

        .assistant-avatar {
            position: relative;
            display: grid;
            flex: 0 0 auto;
            place-items: center;
            width: 43px;
            height: 43px;
            border: 1px solid rgba(7, 153, 170, 0.15);
            border-radius: 13px;
            color: var(--brand-dark);
            background:
                linear-gradient(
                    145deg,
                    #ffffff,
                    var(--brand-light)
                );
            box-shadow: var(--shadow-small);
        }

        .avatar-online {
            position: absolute;
            right: -2px;
            bottom: -2px;
            width: 12px;
            height: 12px;
            border: 3px solid #ffffff;
            border-radius: 50%;
            background: var(--success);
        }

        .assistant-info {
            min-width: 0;
        }

        .assistant-name {
            display: flex;
            align-items: center;
            gap: 7px;
            color: var(--text);
            font-size: 14px;
            font-weight: 700;
        }

        .ai-label {
            padding: 3px 6px;
            border-radius: 20px;
            color: var(--brand-dark);
            background: var(--brand-light);
            font-size: 7px;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        .assistant-subtitle {
            margin-top: 3px;
            color: var(--secondary-text);
            font-size: 9px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Apple-style segmented selector */

        .account-switcher {
            display: flex;
            align-items: center;
            gap: 3px;
            padding: 4px;
            border: 1px solid var(--border);
            border-radius: 13px;
            background: rgba(235, 240, 241, 0.82);
            box-shadow: var(--shadow-small);
        }

        .account-option {
            min-height: 31px;
            padding: 7px 11px;
            border-radius: 9px;
            color: var(--secondary-text);
            background: transparent;
            font-size: 9px;
            font-weight: 650;
            transition:
                color 160ms ease,
                background 160ms ease,
                box-shadow 160ms ease;
        }

        .account-option.active {
            color: var(--text);
            background: #ffffff;
            box-shadow:
                0 3px 10px rgba(23, 53, 58, 0.10);
        }

        .account-option:disabled {
            cursor: wait;
            opacity: 0.5;
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 9px 5px 5px;
            border: 1px solid var(--border);
            border-radius: 13px;
            background: rgba(255, 255, 255, 0.85);
        }

        .user-avatar {
            display: grid;
            place-items: center;
            width: 30px;
            height: 30px;
            border-radius: 9px;
            color: #ffffff;
            background:
                linear-gradient(
                    135deg,
                    #11abba,
                    var(--brand-dark)
                );
            font-size: 9px;
            font-weight: 700;
        }

        .user-name {
            max-width: 110px;
            overflow: hidden;
            color: var(--text);
            font-size: 9px;
            font-weight: 600;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Internal message scrollbar */

        .messages {
            min-height: 0;
            flex: 1;
            overflow-x: hidden;
            overflow-y: auto;
            padding: 25px clamp(20px, 5vw, 70px);
            scroll-behavior: smooth;
            scrollbar-gutter: stable;
            scrollbar-width: thin;
            scrollbar-color:
                rgba(7, 153, 170, 0.38)
                rgba(7, 153, 170, 0.05);
        }

        .messages::-webkit-scrollbar {
            width: 7px;
        }

        .messages::-webkit-scrollbar-track {
            margin: 10px 0;
            border-radius: 20px;
            background: rgba(7, 153, 170, 0.05);
        }

        .messages::-webkit-scrollbar-thumb {
            border: 2px solid transparent;
            border-radius: 20px;
            background: rgba(7, 153, 170, 0.55);
            background-clip: padding-box;
        }

        .messages-inner {
            width: min(880px, 100%);
            min-height: 100%;
            margin: 0 auto;
        }

        /* Initial chatbot screen */

        .welcome {
            display: grid;
            min-height: 100%;
            place-items: center;
            padding: 20px 0 38px;
            animation: welcomeIn 450ms ease both;
        }

        @keyframes welcomeIn {
            from {
                opacity: 0;
                transform: translateY(9px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .welcome-content {
            width: min(660px, 100%);
            text-align: center;
        }

        .orb-container {
            position: relative;
            display: grid;
            width: 120px;
            height: 120px;
            margin: 0 auto 23px;
            place-items: center;
        }

        .orb-ring {
            position: absolute;
            border: 1px solid rgba(7, 153, 170, 0.16);
            border-radius: 50%;
            animation: ringExpand 3s infinite ease-out;
        }

        .orb-ring:nth-child(1) {
            width: 90px;
            height: 90px;
        }

        .orb-ring:nth-child(2) {
            width: 115px;
            height: 115px;
            animation-delay: 1s;
        }

        .orb-ring:nth-child(3) {
            width: 140px;
            height: 140px;
            animation-delay: 2s;
        }

        @keyframes ringExpand {
            0% {
                opacity: 0;
                transform: scale(0.70);
            }

            40% {
                opacity: 0.9;
            }

            100% {
                opacity: 0;
                transform: scale(1.18);
            }
        }

        .ai-orb {
            position: relative;
            display: grid;
            width: 73px;
            height: 73px;
            place-items: center;
            overflow: hidden;
            border: 5px solid rgba(255, 255, 255, 0.9);
            border-radius: 24px;
            color: #ffffff;
            background:
                radial-gradient(
                    circle at 27% 23%,
                    #73eee8,
                    transparent 27%
                ),
                linear-gradient(
                    145deg,
                    #19bdc9,
                    #078899 55%,
                    #075d69
                );
            box-shadow:
                0 20px 43px rgba(7, 153, 170, 0.25);
            animation: orbFloat 3.8s ease-in-out infinite;
        }

        .ai-orb::after {
            position: absolute;
            inset: -30%;
            background:
                linear-gradient(
                    120deg,
                    transparent 35%,
                    rgba(255, 255, 255, 0.34),
                    transparent 65%
                );
            content: "";
            animation: orbLight 4.5s infinite;
        }

        @keyframes orbFloat {
            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-6px);
            }
        }

        @keyframes orbLight {
            0%,
            55% {
                transform: translateX(-110%) rotate(12deg);
            }

            90%,
            100% {
                transform: translateX(110%) rotate(12deg);
            }
        }

        .welcome-kicker {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 10px;
            color: var(--brand-dark);
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 0.11em;
            text-transform: uppercase;
        }

        .welcome-title {
            color: var(--text);
            font-size: clamp(28px, 3.2vw, 43px);
            font-weight: 650;
            letter-spacing: -0.045em;
            line-height: 1.14;
        }

        .welcome-title strong {
            color: var(--brand);
            font-weight: 650;
        }

        .welcome-description {
            max-width: 530px;
            margin: 12px auto 0;
            color: var(--secondary-text);
            font-size: 11px;
            line-height: 1.65;
        }

        .starter-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 9px;
            margin-top: 24px;
        }

        .starter {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            min-height: 60px;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 15px;
            color: var(--text);
            background: rgba(255, 255, 255, 0.76);
            box-shadow: var(--shadow-small);
            text-align: left;
            backdrop-filter: blur(20px);
            transition:
                transform 180ms ease,
                border-color 180ms ease,
                box-shadow 180ms ease;
        }

        .starter:hover {
            border-color: rgba(7, 153, 170, 0.27);
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .starter:disabled {
            cursor: wait;
            opacity: 0.5;
            transform: none;
        }

        .starter-title {
            display: block;
            font-size: 12px;
            font-weight: 650;
        }

        .starter-subtitle {
            display: block;
            margin-top: 4px;
            color: var(--secondary-text);
            font-size: 10px;
        }

        .starter-arrow {
            display: grid;
            flex: 0 0 auto;
            place-items: center;
            width: 27px;
            height: 27px;
            border-radius: 9px;
            color: var(--brand-dark);
            background: var(--brand-light);
            transition:
                color 160ms ease,
                background 160ms ease;
        }

        .starter:hover .starter-arrow {
            color: #ffffff;
            background: var(--brand);
        }

        /* Conversation messages */

        .message-row {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            margin-bottom: 20px;
            animation: messageIn 260ms ease both;
        }

        @keyframes messageIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message-row.user {
            justify-content: flex-end;
        }

        .message-avatar {
            display: grid;
            flex: 0 0 auto;
            place-items: center;
            width: 33px;
            height: 33px;
            border: 1px solid rgba(7, 153, 170, 0.13);
            border-radius: 11px;
            color: var(--brand-dark);
            background: var(--brand-light);
            font-size: 8px;
            font-weight: 700;
        }

        .message-content {
            max-width: min(710px, 78%);
        }

        .message-bubble {
            padding: 10px 16px;
            border: 1px solid var(--border);
            border-radius: 17px 17px 17px 5px;
            color: #394a4e;
            background: rgba(255, 255, 255, 0.88);
            box-shadow: var(--shadow-small);
            font-size: 12px;
            line-height: 1.72;
            word-break: break-word;
            backdrop-filter: blur(18px);
        }

        .message-row.user .message-bubble {
            border: 0;
            border-radius: 17px 17px 5px 17px;
            color: #ffffff;
            background:
                linear-gradient(
                    135deg,
                    #0dabb9,
                    #067784
                );
            box-shadow:
                0 12px 28px rgba(7, 138, 152, 0.20);
        }

        .message-bubble.error {
            border-color: rgba(217, 77, 97, 0.18);
            color: var(--danger);
            background: #fff4f5;
        }

        .message-time {
            display: block;
            margin-top: 3px;
            color: inherit;
            font-size: 10px;
            opacity: 0.48;
        }

        .message-row.user .message-time {
            text-align: right;
        }

        .typing {
            display: flex;
            align-items: center;
            gap: 4px;
            min-width: 64px;
            min-height: 42px;
        }

        .typing span {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--brand);
            animation: typing 1.1s infinite ease-in-out;
        }

        .typing span:nth-child(2) {
            animation-delay: 130ms;
        }

        .typing span:nth-child(3) {
            animation-delay: 260ms;
        }

        @keyframes typing {
            0%,
            60%,
            100% {
                opacity: 0.3;
                transform: translateY(0);
            }

            30% {
                opacity: 1;
                transform: translateY(-5px);
            }
        }

        /* Floating composer */

        .composer-area {
            position: relative;
            z-index: 8;
            flex: 0 0 auto;
            padding: 10px clamp(18px, 4vw, 54px) 14px;
            background:
                linear-gradient(
                    180deg,
                    rgba(245, 247, 247, 0.62),
                    rgba(245, 247, 247, 0.96)
                );
            backdrop-filter: blur(22px);
        }

        .composer-container {
            width: min(900px, 100%);
            margin: 0 auto;
        }

        .composer {
            display: flex;
            align-items: flex-end;
            gap: 9px;
            padding: 7px 7px 7px 15px;
            border: 1px solid var(--border);
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.94);
            box-shadow:
                0 16px 42px rgba(24, 56, 61, 0.10),
                0 0 0 4px rgba(255, 255, 255, 0.55);
            transition:
                border-color 180ms ease,
                box-shadow 180ms ease,
                transform 180ms ease;
        }

        .composer:focus-within {
            border-color: rgba(7, 153, 170, 0.42);
            box-shadow:
                0 18px 46px rgba(7, 153, 170, 0.12),
                0 0 0 4px rgba(7, 153, 170, 0.045);
            transform: translateY(-1px);
        }

        #messageInput {
            width: 100%;
            min-height: 29px;
            max-height: 120px;
            /* padding: 5px 0; */
            resize: none;
            overflow-y: auto;
            border: 0;
            outline: 0;
            color: var(--text);
            background: transparent;
            font-size: 16px;
            /* line-height: 1.55; */
        }

        #messageInput::placeholder {
            color: #a0a0a5;
        }

        .send-button {
            display: grid;
            flex: 0 0 auto;
            place-items: center;
            width: 45px;
            height: 45px;
            border-radius: 13px;
            color: #ffffff;
            background:
                linear-gradient(
                    135deg,
                    #12afbd,
                    var(--brand-dark)
                );
            box-shadow:
                0 9px 22px rgba(7, 153, 170, 0.24);
            transition:
                transform 160ms ease,
                box-shadow 160ms ease;
        }

        .send-button:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow:
                0 13px 27px rgba(7, 153, 170, 0.31);
        }

        .send-button:disabled {
            cursor: wait;
            opacity: 0.60;
        }

        .send-loader {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.35);
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 700ms linear infinite;
        }

        .send-button.loading .send-icon {
            display: none;
        }

        .send-button.loading .send-loader {
            display: block;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .composer-footer {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 8px 4px 0;
            color: var(--tertiary-text);
            font-size: 7px;
        }

        .powered {
            color: var(--brand-dark);
            font-weight: 650;
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            z-index: 40;
            visibility: hidden;
            background: rgba(22, 43, 47, 0.40);
            opacity: 0;
            backdrop-filter: blur(5px);
            transition:
                opacity 200ms ease,
                visibility 200ms ease;
        }

        .sidebar-overlay.active {
            visibility: visible;
            opacity: 1;
        }

        .toast-container {
            position: fixed;
            top: 84px;
            right: 18px;
            z-index: 100;
        }

        .toast {
            margin-bottom: 8px;
            padding: 11px 14px;
            border: 1px solid var(--border);
            border-radius: 12px;
            color: var(--text);
            background: rgba(255, 255, 255, 0.94);
            box-shadow: var(--shadow-medium);
            font-size: 9px;
            font-weight: 600;
            backdrop-filter: blur(20px);
            animation: toastIn 230ms ease both;
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateX(12px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @media (max-width: 920px) {
            :root {
                --sidebar-width: 245px;
            }

            .user-chip {
                display: none;
            }
        }

        @media (max-width: 720px) {
            .app {
                display: block;
            }

            .sidebar {
                position: fixed;
                inset: 0 auto 0 0;
                z-index: 50;
                width: min(280px, 86vw);
                transform: translateX(-105%);
                transition: transform 230ms ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .workspace {
                width: 100%;
                height: 100dvh;
            }

            .mobile-menu {
                display: grid;
            }

            .header {
                padding: 9px 12px;
            }

            .assistant-avatar {
                width: 39px;
                height: 39px;
            }

            .assistant-subtitle,
            .ai-label {
                display: none;
            }

            .account-option {
                padding: 7px 8px;
                font-size: 8px;
            }

            .messages {
                padding: 20px 12px;
            }

            .starter-grid {
                grid-template-columns: 1fr;
            }

            .message-content {
                max-width: 88%;
            }

            .composer-area {
                padding: 9px 11px 12px;
            }

            .composer-footer {
                justify-content: center;
            }

            .composer-footer span:first-child {
                display: none;
            }
        }

        @media (max-width: 450px) {
            .assistant-name {
                font-size: 11px;
            }

            .account-option {
                max-width: 72px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .welcome-title {
                font-size: 29px;
            }

            .message-content {
                max-width: 92%;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>

<body>
    <div id="sidebarOverlay"
         class="sidebar-overlay"></div>

    <div id="toastContainer"
         class="toast-container"
         aria-live="polite"></div>

    <div class="app">
        <aside id="sidebar"
               class="sidebar">
            <div class="sidebar-scroll">
                <div class="brand">
                    <img id="brandLogo"
                         class="brand-logo"
                         src="{{ asset('uploads/code-sparrow-logo.png') }}"
                         alt="Code Sparrow">

                    <div id="brandFallback"
                         class="brand-fallback"
                         hidden>
                        CODE SPARROW
                    </div>
                </div>

                <button id="newChatButton"
                        class="new-chat"
                        type="button">
                    <svg width="16"
                         height="16"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>

                    New conversation
                </button>

                <div class="section-label">
                    Suggested
                </div>

                <div class="prompt-list">
                    <button class="prompt"
                            type="button"
                            data-question="Total leads kitni hain?">
                        <span class="prompt-icon">01</span>

                        <span class="prompt-text">
                            Total leads kitni hain?
                        </span>
                    </button>

                    <button class="prompt"
                            type="button"
                            data-question="Rejected leads aur closed deals kitni hain?">
                        <span class="prompt-icon">02</span>

                        <span class="prompt-text">
                            Rejected leads and closed deals
                        </span>
                    </button>

                    <button class="prompt"
                            type="button"
                            data-question="Top 5 salespersons by assigned leads batao.">
                        <span class="prompt-icon">03</span>

                        <span class="prompt-text">
                            Top performing salespersons
                        </span>
                    </button>

                    <button class="prompt"
                            type="button"
                            data-question="Show me this month's lead performance.">
                        <span class="prompt-icon">04</span>

                        <span class="prompt-text">
                            This month’s performance
                        </span>
                    </button>

                    <button class="prompt"
                            type="button"
                            data-question="Kitne salespersons hain?">
                        <span class="prompt-icon">05</span>

                        <span class="prompt-text">
                            Total salespersons
                        </span>
                    </button>
                </div>
            </div>

            <div class="sidebar-footer">
                <div class="status-card">
                    <div class="status-title">
                        <span class="status-dot"></span>
                        AI service connected
                    </div>

                    <div id="activeAccount"
                         class="active-account">
                        Primary Groq selected
                    </div>

                    <div class="status-note">
                        Secure read-only CRM database access.
                    </div>
                </div>
            </div>
        </aside>

        <section class="workspace">
            <header class="header">
                <div class="header-left">
                    <button id="mobileMenuButton"
                            class="mobile-menu"
                            type="button"
                            aria-label="Open menu">
                        <svg width="18"
                             height="18"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">
                            <path d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <div class="assistant-avatar">
                        <svg width="21"
                             height="21"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">
                            <rect x="3"
                                  y="6"
                                  width="18"
                                  height="14"
                                  rx="5"/>

                            <path d="M8 11h.01M16 11h.01M8 15h8M12 3v3"/>
                        </svg>

                        <span class="avatar-online"></span>
                    </div>

                    <div class="assistant-info">
                        <div class="assistant-name">
                            CRM AI Assistant

                            <span class="ai-label">
                                AGENTIC AI
                            </span>
                        </div>

                        <div class="assistant-subtitle">
                            Ask naturally in Hindi, English or Hinglish
                        </div>
                    </div>
                </div>

                <div class="header-actions">
                    <div class="account-switcher"
                         aria-label="Select AI account">
                        <button class="account-option"
                                type="button"
                                data-api-profile="primary">
                            Primary
                        </button>

                        <button class="account-option"
                                type="button"
                                data-api-profile="secondary">
                            Secondary
                        </button>
                    </div>

                    <div class="user-chip">
                        <span class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </span>

                        <span class="user-name">
                            {{ auth()->user()->name ?? 'CRM User' }}
                        </span>
                    </div>
                </div>
            </header>

            <main id="messages"
                  class="messages">
                <div id="messagesInner"
                     class="messages-inner"></div>
            </main>

            <footer class="composer-area">
                <div class="composer-container">
                    <form id="chatForm"
                          class="composer">
                        <textarea
                            id="messageInput"
                            rows="1"
                            maxlength="2000"
                            autocomplete="off"
                            placeholder="Message your CRM Assistant..."
                        ></textarea>

                        <button id="sendButton"
                                class="send-button"
                                type="submit"
                                aria-label="Send message">
                            <span class="send-icon">
                                <svg width="19"
                                     height="19"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <path d="M22 2 11 13"/>
                                    <path d="m22 2-7 20-4-9-9-4Z"/>
                                </svg>
                            </span>

                            <span class="send-loader"></span>
                        </button>
                    </form>

                    <div class="composer-footer">
                        <span>
                            Enter to send • Shift + Enter for new line
                        </span>

                        <span>
                            Secured by
                            <span class="powered">
                                Code Sparrow
                            </span>
                        </span>
                    </div>
                </div>
            </footer>
        </section>
    </div>

    <script>
        const chatForm =
            document.getElementById('chatForm');

        const messageInput =
            document.getElementById('messageInput');

        const messages =
            document.getElementById('messages');

        const messagesInner =
            document.getElementById('messagesInner');

        const sendButton =
            document.getElementById('sendButton');

        const profileButtons =
            document.querySelectorAll('[data-api-profile]');

        const activeAccount =
            document.getElementById('activeAccount');

        const newChatButton =
            document.getElementById('newChatButton');

        const sidebar =
            document.getElementById('sidebar');

        const sidebarOverlay =
            document.getElementById('sidebarOverlay');

        const mobileMenuButton =
            document.getElementById('mobileMenuButton');

        const toastContainer =
            document.getElementById('toastContainer');

        const brandLogo =
            document.getElementById('brandLogo');

        const brandFallback =
            document.getElementById('brandFallback');

        const csrfToken = document.querySelector(
            'meta[name="csrf-token"]'
        ).content;

        const sendUrl = @json(route('ai-chat.send'));

        const allowedProfiles = [
            'primary',
            'secondary'
        ];

        let selectedProfile =
            localStorage.getItem('crm_ai_api_profile')
            || 'primary';

        let processing = false;
        let threadId = createThreadId();

        function createThreadId() {
            if (
                window.crypto
                && typeof crypto.randomUUID === 'function'
            ) {
                return crypto.randomUUID();
            }

            return 'chat-'
                + Date.now()
                + '-'
                + Math.random().toString(16).slice(2);
        }

        function profileName(profile) {
            return profile === 'secondary'
                ? 'Secondary Groq'
                : 'Primary Groq';
        }

        function setProfile(profile, notify = false) {
            if (!allowedProfiles.includes(profile)) {
                profile = 'primary';
            }

            selectedProfile = profile;

            localStorage.setItem(
                'crm_ai_api_profile',
                profile
            );

            profileButtons.forEach(button => {
                const active =
                    button.dataset.apiProfile === profile;

                button.classList.toggle(
                    'active',
                    active
                );

                button.setAttribute(
                    'aria-pressed',
                    active ? 'true' : 'false'
                );
            });

            activeAccount.textContent =
                profileName(profile) + ' selected';

            if (notify) {
                showToast(
                    profileName(profile) + ' is now active'
                );
            }
        }

        function showToast(text) {
            const toast =
                document.createElement('div');

            toast.className = 'toast';
            toast.textContent = text;

            toastContainer.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';

                setTimeout(() => {
                    toast.remove();
                }, 200);
            }, 2000);
        }

        function renderWelcome() {
            messagesInner.innerHTML = `
                <section id="welcome"
                         class="welcome">
                    <div class="welcome-content">
                        <div class="orb-container">
                            <span class="orb-ring"></span>
                            <span class="orb-ring"></span>
                            <span class="orb-ring"></span>

                            <div class="ai-orb">
                                <svg
                                    width="55"
                                    height="55"
                                    viewBox="0 0 512 512"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="9"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true"
                                >
                                    <!-- Antenna -->
                                    <circle cx="45" cy="127" r="24"/>
                                    <path d="M51 151L70 222"/>

                                    <!-- Robot head -->
                                    <path d="
                                        M298 145H176
                                        C136 145 104 177 104 217
                                        V316
                                        C104 356 136 389 176 389
                                        V450
                                        Q176 466 187 452
                                        L234 389H322
                                        C362 389 394 357 394 317
                                        V217
                                        Q394 199 387 187
                                    "/>

                                    <!-- Top curve -->
                                    <path d="M175 145C198 93 250 78 298 111"/>

                                    <!-- Side earpieces -->
                                    <path d="
                                        M104 214H93
                                        C76 214 63 228 63 246
                                        V274
                                        C63 292 76 306 93 306
                                        H104
                                    "/>
                                    <path d="
                                        M394 214H405
                                        C422 214 436 228 436 246
                                        V274
                                        C436 292 422 306 405 306
                                        H394
                                    "/>

                                    <!-- Face and eyes -->
                                    <path d="
                                        M337 210H174
                                        C154 210 138 226 138 246
                                        V258
                                        C138 278 154 294 174 294
                                        H325
                                        C345 294 361 278 361 258
                                        V246
                                        Q361 232 353 223
                                    "/>
                                    <circle cx="195" cy="252" r="19"/>
                                    <circle cx="304" cy="252" r="19"/>
                                    <path d="M220 340H279"/>

                                    <!-- Headset microphone -->
                                    <path d="M394 319V368C394 401 367 427 334 427H314"/>
                                    <rect x="254" y="410" width="60" height="34" rx="17"/>
                                    <path d="M278 410V444"/>

                                    <!-- Chat bubble -->
                                    <path d="
                                        M325 55H464
                                        C479 55 491 67 491 82
                                        V160
                                        C491 175 479 187 464 187
                                        H378
                                        L337 231
                                        V187H325
                                        C310 187 298 175 298 160
                                        V82
                                        C298 67 310 55 325 55Z
                                    "/>
                                    <path d="M332 92H457M332 122H457M332 153H397"/>
                                </svg>
                            </div>
                        </div>

                        <div class="welcome-kicker">
                            <span class="status-dot"></span>
                            CRM Intelligence is ready
                        </div>

                        <h1 class="welcome-title">
                            How can I help with your
                            <strong>CRM today?</strong>
                        </h1>

                        <p class="welcome-description">
                            Leads, deals, salespersons aur business
                            performance ke baare mein naturally
                            baat karein.
                        </p>

                        <div class="starter-grid">
                            <button class="starter"
                                    type="button"
                                    data-starter-question="Total leads kitni hain?">
                                <span>
                                    <span class="starter-title">
                                        Total leads
                                    </span>

                                    <span class="starter-subtitle">
                                        Overall lead count
                                    </span>
                                </span>

                                <span class="starter-arrow">→</span>
                            </button>

                            <button class="starter"
                                    type="button"
                                    data-starter-question="Rejected leads kitni hain?">
                                <span>
                                    <span class="starter-title">
                                        Rejected leads
                                    </span>

                                    <span class="starter-subtitle">
                                        Rejection report
                                    </span>
                                </span>

                                <span class="starter-arrow">→</span>
                            </button>

                            <button class="starter"
                                    type="button"
                                    data-starter-question="Top 5 salespersons batao.">
                                <span>
                                    <span class="starter-title">
                                        Sales performance
                                    </span>

                                    <span class="starter-subtitle">
                                        Top salespersons
                                    </span>
                                </span>

                                <span class="starter-arrow">→</span>
                            </button>

                            <button class="starter"
                                    type="button"
                                    data-starter-question="Is month ki lead performance batao.">
                                <span>
                                    <span class="starter-title">
                                        Monthly insights
                                    </span>

                                    <span class="starter-subtitle">
                                        Current month report
                                    </span>
                                </span>

                                <span class="starter-arrow">→</span>
                            </button>
                        </div>
                    </div>
                </section>
            `;

            bindStarterButtons();
        }

        function bindStarterButtons() {
            document
                .querySelectorAll(
                    '[data-starter-question]'
                )
                .forEach(button => {
                    button.addEventListener(
                        'click',
                        function () {
                            sendMessage(
                                this.dataset.starterQuestion
                            );
                        }
                    );
                });
        }

        function removeWelcome() {
            document
                .getElementById('welcome')
                ?.remove();
        }

        function currentTime() {
            return new Intl.DateTimeFormat('en-IN', {
                hour: '2-digit',
                minute: '2-digit'
            }).format(new Date());
        }

        function escapeHtml(value) {
            const element =
                document.createElement('div');

            element.textContent =
                String(value ?? '');

            return element.innerHTML;
        }

        function formatBotMessage(value) {
            return escapeHtml(value)
                .replace(
                    /\*\*(.*?)\*\*/g,
                    '<strong>$1</strong>'
                )
                .replace(/\n/g, '<br>');
        }

        function scrollToBottom(smooth = true) {
            messages.scrollTo({
                top: messages.scrollHeight,
                behavior: smooth ? 'smooth' : 'auto'
            });
        }

        function addMessage(
            text,
            sender,
            isError = false
        ) {
            const row =
                document.createElement('div');

            row.className =
                `message-row ${sender}`;

            if (sender === 'bot') {
                const avatar =
                    document.createElement('div');

                avatar.className = 'message-avatar';
                avatar.textContent = 'AI';

                row.appendChild(avatar);
            }

            const content =
                document.createElement('div');

            content.className = 'message-content';

            const bubble =
                document.createElement('div');

            bubble.className =
                `message-bubble${isError ? ' error' : ''}`;

            if (sender === 'bot') {
                bubble.innerHTML =
                    formatBotMessage(text);
            } else {
                bubble.textContent = text;
            }

            const time =
                document.createElement('span');

            time.className = 'message-time';
            time.textContent = currentTime();

            bubble.appendChild(time);
            content.appendChild(bubble);
            row.appendChild(content);
            messagesInner.appendChild(row);

            scrollToBottom();
        }

        function showTyping() {
            const row =
                document.createElement('div');

            row.id = 'typingRow';
            row.className = 'message-row bot';

            row.innerHTML = `
                <div class="message-avatar">AI</div>

                <div class="message-content">
                    <div class="message-bubble typing">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            `;

            messagesInner.appendChild(row);
            scrollToBottom();
        }

        function removeTyping() {
            document
                .getElementById('typingRow')
                ?.remove();
        }

        function resizeInput() {
            messageInput.style.height = 'auto';

            messageInput.style.height =
                Math.min(
                    messageInput.scrollHeight,
                    120
                ) + 'px';
        }

        function setProcessing(value) {
            processing = value;

            messageInput.disabled = value;
            sendButton.disabled = value;

            sendButton.classList.toggle(
                'loading',
                value
            );

            document
                .querySelectorAll(
                    '[data-question],'
                    + '[data-starter-question],'
                    + '[data-api-profile]'
                )
                .forEach(button => {
                    button.disabled = value;
                });
        }

        function openSidebar() {
            sidebar.classList.add('open');
            sidebarOverlay.classList.add('active');
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('active');
        }

        async function sendMessage(question = null) {
            const message = (
                question ?? messageInput.value
            ).trim();

            if (!message || processing) {
                return;
            }

            closeSidebar();
            removeWelcome();
            setProcessing(true);

            addMessage(message, 'user');

            messageInput.value = '';
            resizeInput();
            showTyping();

            try {
                const response = await fetch(sendUrl, {
                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },

                    body: JSON.stringify({
                        message: message,
                        thread_id: threadId,
                        api_profile: selectedProfile
                    })
                });

                let data;

                try {
                    data = await response.json();
                } catch (error) {
                    data = {
                        message:
                            'Invalid response received.'
                    };
                }

                removeTyping();

                if (!response.ok) {
                    throw new Error(
                        data.message
                        || 'Unable to process your question.'
                    );
                }

                threadId =
                    data.thread_id || threadId;

                if (
                    data.api_profile
                    && allowedProfiles.includes(
                        data.api_profile
                    )
                ) {
                    setProfile(
                        data.api_profile,
                        false
                    );
                }

                addMessage(
                    data.message
                    || 'No answer received.',
                    'bot'
                );
            } catch (error) {
                removeTyping();

                addMessage(
                    error.message
                    || 'Something went wrong.',
                    'bot',
                    true
                );
            } finally {
                setProcessing(false);
                messageInput.focus();
            }
        }

        brandLogo.addEventListener('error', () => {
            brandLogo.hidden = true;
            brandFallback.hidden = false;
        });

        profileButtons.forEach(button => {
            button.addEventListener(
                'click',
                function () {
                    setProfile(
                        this.dataset.apiProfile,
                        true
                    );
                }
            );
        });

        newChatButton.addEventListener(
            'click',
            function () {
                threadId = createThreadId();
                renderWelcome();
                closeSidebar();

                showToast(
                    'New conversation started'
                );

                messageInput.focus();
            }
        );

        mobileMenuButton.addEventListener(
            'click',
            function () {
                if (sidebar.classList.contains('open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            }
        );

        sidebarOverlay.addEventListener(
            'click',
            closeSidebar
        );

        chatForm.addEventListener(
            'submit',
            function (event) {
                event.preventDefault();
                sendMessage();
            }
        );

        messageInput.addEventListener(
            'input',
            resizeInput
        );

        messageInput.addEventListener(
            'keydown',
            function (event) {
                if (
                    event.key === 'Enter'
                    && !event.shiftKey
                ) {
                    event.preventDefault();
                    sendMessage();
                }
            }
        );

        document
            .querySelectorAll('[data-question]')
            .forEach(button => {
                button.addEventListener(
                    'click',
                    function () {
                        sendMessage(
                            this.dataset.question
                        );
                    }
                );
            });

        window.addEventListener(
            'keydown',
            function (event) {
                if (event.key === 'Escape') {
                    closeSidebar();
                }
            }
        );

        setProfile(selectedProfile);
        renderWelcome();
        messageInput.focus();
    </script>
</body>
</html>
