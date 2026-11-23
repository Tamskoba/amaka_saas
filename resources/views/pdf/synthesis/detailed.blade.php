<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <title>Synthèse fonctionnelle détaillée</title>

    <style>
        @page {
            margin: 35px 38px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #4B2E1F;
            line-height: 1.6;
        }

        .header {
            background: #4B2E1F;
            color: white;
            padding: 22px;
            margin-bottom: 22px;
        }

        .brand {
            color: #EADFD3;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        h1 {
            font-size: 21px;
            margin: 8px 0;
        }

        .subtitle {
            color: #F7F2EE;
            font-size: 10px;
        }

        .identity {
            border: 1px solid #EADFD3;
            background: #F7F2EE;
            padding: 12px;
            margin-bottom: 22px;
        }

        .identity p {
            margin: 3px 0;
        }

        .rubric {
            margin-bottom: 20px;
            page-break-inside: auto;
        }

        .rubric-header {
            background: #F7F2EE;
            border-left: 4px solid #C87A2A;
            padding: 10px 12px;
            margin-bottom: 12px;
        }

        .rubric-number {
            color: #8A5A44;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        h2 {
            font-size: 13px;
            margin: 3px 0 0;
        }

        .item {
            border: 1px solid #EADFD3;
            padding: 12px;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        .question {
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 8px;
        }

        .answer-label {
            color: #8A5A44;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .answer {
            background: #FDFBF9;
            padding: 9px;
            margin-top: 4px;
            white-space: pre-wrap;
        }

        .metadata {
            background: #F7F2EE;
            padding: 8px;
            margin-top: 8px;
            font-size: 8px;
            color: #6B4A3A;
        }

        .metadata p {
            margin: 2px 0;
        }

        .empty {
            border: 1px dashed #DCCABC;
            padding: 12px;
            color: #8A5A44;
            font-style: italic;
        }

        .footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #8A5A44;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="brand">AmakaNutrition · Parcours santé</div>

        <h1>{{ $synthesis['title'] }}</h1>

        <div class="subtitle">
            Synthèse des informations déclarées dans les questionnaires.
        </div>
    </div>

    <div class="identity">
        <p>
            <strong>Cliente :</strong>
            {{ trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: 'Non renseigné' }}
        </p>

        <p>
            <strong>Session :</strong>
            {{ $session->session_number ?? 'Non renseignée' }}
        </p>

        <p>
            <strong>Date d'export :</strong>
            {{ $exportedAt->format('d/m/Y à H:i') }}
        </p>
    </div>

    @foreach ($synthesis['rubrics'] ?? [] as $rubric)

        <div class="rubric">

            <div class="rubric-header">
                <div class="rubric-number">
                    Rubrique {{ $rubric['number'] }}
                </div>

                <h2>{{ $rubric['title'] }}</h2>
            </div>

            @if (!empty($rubric['has_data']))

                @foreach ($rubric['items'] as $item)

                    <div class="item">

                        <div class="question">
                            {{ $item['question'] }}
                        </div>

                        <div class="answer-label">
                            Réponse déclarée
                        </div>

                        <div class="answer">
                            {{ $item['answer'] }}
                        </div>

                        @if ($showMetadata)

                            <div class="metadata">

                                <p>
                                    <strong>Questionnaire :</strong>
                                    {{ $item['questionnaire'] }}
                                </p>

                                <p>
                                    <strong>Section d'origine :</strong>
                                    {{ $item['section'] }}
                                </p>

                                <p>
                                    <strong>Clé technique :</strong>
                                    {{ $item['question_key'] }}
                                </p>

                                <p>
                                    <strong>Statut :</strong>
                                    {{ $item['status'] }}
                                    — Progression : {{ $item['progress'] }} %
                                </p>

                            </div>

                        @endif

                    </div>

                @endforeach

            @else

                <div class="empty">
                    {{ $rubric['empty_message'] ?? 'Aucune information disponible dans les questionnaires' }}
                </div>

            @endif

        </div>

    @endforeach

    <div class="footer">
        AmakaNutrition — Synthèse fonctionnelle détaillée
    </div>

</body>
</html>