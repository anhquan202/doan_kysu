class Supply < ApplicationRecord
  has_many :room_supplies, dependent: :destroy
  has_many :rooms, through: :room_supplies

  validates :supply_name, presence: true
  validates :unit, presence: true

  enum :unit, { set: 0, piece: 1 }
end
