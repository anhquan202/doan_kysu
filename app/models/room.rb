class Room < ApplicationRecord
  enum :room_type, single: 0, double: 1, studio: 2
  enum :status, available: 0, maintenance: 2, cleaning: 3, unavailable: 4

  validates :room_code, presence: true, uniqueness: true
  validates :room_type, presence: true
  validates :price, presence: true
  validates :max_customer, presence: true, numericality: { only_integer: true, greater_than_or_equal_to: 1, less_than_or_equal_to: 3 }

  has_one :contract, dependent: :destroy
  has_many :room_supplies, dependent: :destroy
  has_many :supplies, through: :room_supplies
end
