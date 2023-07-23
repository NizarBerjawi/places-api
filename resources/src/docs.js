
import SwaggerUI from 'swagger-ui'
import './styles/docs.scss';

const spec = require('../../public/openApi.json');

const ui = SwaggerUI({
  spec,
  dom_id: '#swagger',
});

export default ui;