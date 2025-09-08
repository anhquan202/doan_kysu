# This file should ensure the existence of records required to run the application in every environment (production,
# development, test). The code here should be idempotent so that it can be executed at any point in every environment.
# The data can then be loaded with the bin/rails db:seed command (or created alongside the database with db:setup).
#
# Example:
#
#   ["Action", "Comedy", "Drama", "Horror"].each do |genre_name|
#     MovieGenre.find_or_create_by!(name: genre_name)
#   end
require "faker"
room_types = [0, 1]
20.times do
  Room.create!(
    room_type: room_types.sample,
    room_code: "R#{Faker::Number.number(digits: 4)}",
    price: Faker::Number.between(from: 3, to: 5) * 1_000_000,
    max_customer: Faker::Number.between(from: 1, to: 3),
    created_at: Faker::Time.backward(days: 30, period: :evening),
    updated_at: Time.now
  )
end