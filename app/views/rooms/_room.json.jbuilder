json.extract! room, :id, :room_type, :room_code, :max_customer, :created_at, :updated_at
json.url room_url(room, format: :json)
