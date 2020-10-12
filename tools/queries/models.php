<?php

#SELECT models.id as 'id', m_models.id as 'линейка id', model_types.name as 'тип', markas.name as 'марка', m_models.name as 'линейка', models.name as 'имя' FROM `models` JOIN m_models ON models.m_model_id = m_models.id JOIN markas ON m_models.marka_id = markas.id JOIN model_types ON m_models.model_type_id = model_types.id

?>
