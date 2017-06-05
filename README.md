[![](https://scdn.rapidapi.com/RapidAPI_banner.png)](https://rapidapi.com/package/HuffingtonPostPollster/functions?utm_source=RapidAPIGitHub_HuffingtonPostPollsterFunctions&utm_medium=button&utm_content=RapidAPI_GitHub)

# HuffingtonPostPollster Package
HuffPost is an American journalism company that has both localized and international editions founded by Arianna Huffington, Kenneth Lerer, Jonah Peretti, and Andrew Breitbart, featuring columnists. The site offers news, satire, blogs, and original content and covers politics, business, entertainment, environment, technology, popular media, lifestyle, culture, comedy, healthy living, women's interests, and local news.
* Domain: [HuffingtonPostPollster](http://elections.huffingtonpost.com)
 
## HuffingtonPostPollster.getPolls
A Poll on Pollster is a collection of questions and responses published by a reputable survey house. This endpoint provides raw data from the survey house, plus Pollster-provided metadata about each question. Pollster editors don’t include every question when they enter Polls, and they don’t necessarily enter every subpopulation for the responses they do enter. They make editorial decisions about which questions belong in the database.

| Field   | Type  | Description
|---------|-------|----------
| cursor  | String| Special string to index into the Array
| tags    | List  | List of Question tag names; only Polls containing Questions with any of the given tags will be returned.
| question| String| Question slug; only Polls that ask that Question will be returned.
| sort    | String| If updated_at, sort the most recently updated Poll first. (This can cause race conditions when used with cursor.) Otherwise, sort by most recently entered Poll first.

## HuffingtonPostPollster.getSinglePoll
A Poll on Pollster is a collection of questions and responses published by a reputable survey house. This endpoint provides raw data from the survey house, plus Pollster-provided metadata about each question. Pollster editors don’t include every question when they enter Polls, and they don’t necessarily enter every subpopulation for the responses they do enter. They make editorial decisions about which questions belong in the database.

| Field| Type  | Description
|-----|-------|----------
| slug| String| Unique Poll identifier. For example: gallup-26892

## HuffingtonPostPollster.getQuestions
Returns a list of Questions.

| Field       | Type  | Description
|-------------|-------|----------
| cursor      | String| Special string to index into the Array
| tags        | List  | List of Question tag names. Only Questions with one or more of these tags will be returned.
| electionDate| DatePicker | Date of an election, in YYYY-MM-DD format. Only Questions pertaining to an election on this date will be returned.

## HuffingtonPostPollster.getSingleQuestion
A Question is chosen by Pollster editors. One example is "Obama job approval".

| Field| Type  | Description
|-----|-------|----------
| slug| String| Unique Question identifier. For example: 00c -Pres (44) Obama - Job Approval - National. (Remember to URL-encode this parameter when querying.)

## HuffingtonPostPollster.getSingleQuestionCleanResponses
We include one TSV column per response label. See questions/{slug} for the Question’s list of response labels, which are chosen by Pollster editors. Each row represents a single PollQuestion+Subpopulation. The value for each label column is the sum of the PollQuestion+Subpopulation responses that map to that pollster_label. For instance, on a hypothetical row, the Approve column might be the sum of that poll’s Strongly Approve and Somewhat Approve. After the first TSV columns – which are always response labels – the next column will be poll_slug. poll_slug and subsequent columns are described in this API documentation. During the lifetime of a Question, Pollster editors may add, rename or reorder response labels. Such edits will change the TSV column headers. Column headers after poll_slug are never reordered or edited (but we may add new column headers). Sometimes a Poll may ask the same Question twice, leading to two similar rows with different values. Those rows will differ by question_text or by the set of response labels that have values.

| Field| Type  | Description
|-----|-------|----------
| slug| String| Unique Question identifier. For example: 00c -Pres (44) Obama - Job Approval - National. (Remember to URL-encode this parameter when querying.)

## HuffingtonPostPollster.getSingleQuestionRawResponses
Raw data from which we derived poll-responses-clean.tsv. Each row represents a single PollQuestion+Subpopulation+Response. See the Poll API for a description of these terms. Group results by (poll_slug, subpopulation, question_text): that’s how the survey houses group them. This response can be several megabytes large. We encourage you to consider poll-responses-clean.tsv instead. Try it outTry it out

| Field| Type  | Description
|-----|-------|----------
| slug| String| Unique Question identifier. For example: 00c -Pres (44) Obama - Job Approval - National. (Remember to URL-encode this parameter when querying.)

## HuffingtonPostPollster.getCharts
Returns a list of Charts, ordered by creation date (newest first). A Chart is chosen by Pollster editors. One example is "Obama job approval - Democrats". It is always based upon a single Question. Users should strongly consider basing their analysis on Questions instead. Charts are derived data; Pollster editors publish them and change them as editorial priorities change. Try it outTry it out

| Field       | Type  | Description
|-------------|-------|----------
| cursor      | String| Special string to index into the Array
| tags        | List  | List of tag slugs. Only Charts with one or more of these tags and Charts based on Questions with one or more of these tags will be returned.
| electionDate| DatePicker | Date of an election, in YYYY-MM-DD format. Only Charts based on Questions pertaining to an election on this date will be returned.

## HuffingtonPostPollster.getSingleChart
A Chart is chosen by Pollster editors. One example is "Obama job approval - Democrats". It is always based upon a single Question. Users should strongly consider basing their analysis on Questions instead. Charts are derived data; Pollster editors publish them and change them as editorial priorities change.

| Field| Type  | Description
|-----|-------|----------
| slug| String| Unique identifier for a Chart

## HuffingtonPostPollster.getPollsterChartData
Derived data resented on a Pollster Chart. Rules for which polls and responses are plotted on a chart can shift over time. Here are some examples of behaviors Pollster has used in the past: We’ve omitted “Registered Voters” from a chart when “Likely Voters” responded to the same poll question. We’ve omitted poll questions that asked about Gary Johnson on a chart about Trump v Clinton. We’ve omitted polls when their date ranges overlapped. We’ve omitted labels (and their responses) for dark-horse candidates. In short: this endpoint is about Pollster, not the polls. For complete data, use a TSV from the Questions API.

| Field| Type  | Description
|-----|-------|----------
| slug| String| Unique Chart identifier. For example: obama-job-approval

## HuffingtonPostPollster.getPollsterChartTrendlinesData
Derived data presented on a Pollster Chart. The trendlines on a Pollster chart don’t add up to 100: we calculate each label’s trendline separately. Use the charts/{slug} response’s chart.pollster_estimates[0].algorithm to find the algorithm Pollster used to generate these estimates. Pollster recalculates trendlines every time a new poll is entered. It also recalculates trendlines daily if they use the bayesian-kallman algorithm, because that algorithm’s output changes depending on the end date.

| Field| Type  | Description
|-----|-------|----------
| slug| String| Unique Chart identifier. For example: obama-job-approval

## HuffingtonPostPollster.getTags
Returns the list of Tags. A Tag can apply to any number of Charts and Questions; Charts and Questions, in turn, can have any number of Tags. Tags all look like-this: lowercase letters, numbers and hyphens. Try it outTry it out

No arguments.

